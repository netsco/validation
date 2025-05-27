<?php

namespace Rakit\Validation;

use Rakit\Validation\Traits\TranslationsTrait;
use Rakit\Validation\Traits\MessagesTrait;
use Rakit\Validation\Rules\Required;
use Rakit\Validation\Rules\RequiredIf;
use Rakit\Validation\Rules\RequiredUnless;
use Rakit\Validation\Rules\RequiredWith;
use Rakit\Validation\Rules\RequiredWithout;
use Rakit\Validation\Rules\RequiredWithAll;
use Rakit\Validation\Rules\RequiredWithoutAll;
use Rakit\Validation\Rules\Email;
use Rakit\Validation\Rules\Alpha;
use Rakit\Validation\Rules\Numeric;
use Rakit\Validation\Rules\AlphaNum;
use Rakit\Validation\Rules\AlphaDash;
use Rakit\Validation\Rules\AlphaSpaces;
use Rakit\Validation\Rules\In;
use Rakit\Validation\Rules\NotIn;
use Rakit\Validation\Rules\Min;
use Rakit\Validation\Rules\Max;
use Rakit\Validation\Rules\Between;
use Rakit\Validation\Rules\Url;
use Rakit\Validation\Rules\Integer;
use Rakit\Validation\Rules\Boolean;
use Rakit\Validation\Rules\Ip;
use Rakit\Validation\Rules\Ipv4;
use Rakit\Validation\Rules\Ipv6;
use Rakit\Validation\Rules\Extension;
use Rakit\Validation\Rules\TypeArray;
use Rakit\Validation\Rules\Same;
use Rakit\Validation\Rules\Regex;
use Rakit\Validation\Rules\Date;
use Rakit\Validation\Rules\Accepted;
use Rakit\Validation\Rules\Present;
use Rakit\Validation\Rules\Different;
use Rakit\Validation\Rules\UploadedFile;
use Rakit\Validation\Rules\Mimes;
use Rakit\Validation\Rules\Callback;
use Rakit\Validation\Rules\Before;
use Rakit\Validation\Rules\After;
use Rakit\Validation\Rules\Lowercase;
use Rakit\Validation\Rules\Uppercase;
use Rakit\Validation\Rules\Json;
use Rakit\Validation\Rules\Digits;
use Rakit\Validation\Rules\DigitsBetween;
use Rakit\Validation\Rules\Defaults;
use Rakit\Validation\Rules\Nullable;

class Validator
{
    use TranslationsTrait;
    use MessagesTrait;
    /** @var array */
    protected $translations = [];

    /** @var array */
    protected $validators = [];

    /** @var bool */
    protected $allowRuleOverride = false;

    /** @var bool */
    protected $useHumanizedKeys = true;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
        $this->registerBaseValidators();
    }

    /**
     * Register or override existing validator
     *
     * @param mixed $key
     */
    public function setValidator(string $key, Rule $rule): void
    {
        $this->validators[$key] = $rule;
        $rule->setKey($key);
    }

    /**
     * Get validator object from given $key
     *
     * @return mixed
     */
    public function getValidator(mixed $key)
    {
        return $this->validators[$key] ?? null;
    }

    /**
     * Validate $inputs
     */
    public function validate(array $inputs, array $rules, array $messages = []): Validation
    {
        $validation = $this->make($inputs, $rules, $messages);
        $validation->validate();
        return $validation;
    }

    /**
     * Given $inputs, $rules and $messages to make the Validation class instance
     */
    public function make(array $inputs, array $rules, array $messages = []): Validation
    {
        $messages = array_merge($this->messages, $messages);
        $validation = new Validation($this, $inputs, $rules, $messages);
        $validation->setTranslations($this->getTranslations());

        return $validation;
    }

    /**
     * Magic invoke method to make Rule instance
     *
     * @throws RuleNotFoundException
     */
    public function __invoke(string $rule): Rule
    {
        $args = func_get_args();
        $rule = array_shift($args);
        $params = $args;
        $validator = $this->getValidator($rule);
        if (!$validator) {
            throw new RuleNotFoundException("Validator '{$rule}' is not registered", 1);
        }

        $clonedValidator = clone $validator;
        $clonedValidator->fillParameters($params);

        return $clonedValidator;
    }

    /**
     * Initialize base validators array
     *
     * @return void
     */
    protected function registerBaseValidators()
    {
        $baseValidator = [
            'required'                  => new Required,
            'required_if'               => new RequiredIf,
            'required_unless'           => new RequiredUnless,
            'required_with'             => new RequiredWith,
            'required_without'          => new RequiredWithout,
            'required_with_all'         => new RequiredWithAll,
            'required_without_all'      => new RequiredWithoutAll,
            'email'                     => new Email,
            'alpha'                     => new Alpha,
            'numeric'                   => new Numeric,
            'alpha_num'                 => new AlphaNum,
            'alpha_dash'                => new AlphaDash,
            'alpha_spaces'              => new AlphaSpaces,
            'in'                        => new In,
            'not_in'                    => new NotIn,
            'min'                       => new Min,
            'max'                       => new Max,
            'between'                   => new Between,
            'url'                       => new Url,
            'integer'                   => new Integer,
            'boolean'                   => new Boolean,
            'ip'                        => new Ip,
            'ipv4'                      => new Ipv4,
            'ipv6'                      => new Ipv6,
            'extension'                 => new Extension,
            'array'                     => new TypeArray,
            'same'                      => new Same,
            'regex'                     => new Regex,
            'date'                      => new Date,
            'accepted'                  => new Accepted,
            'present'                   => new Present,
            'different'                 => new Different,
            'uploaded_file'             => new UploadedFile,
            'mimes'                     => new Mimes,
            'callback'                  => new Callback,
            'before'                    => new Before,
            'after'                     => new After,
            'lowercase'                 => new Lowercase,
            'uppercase'                 => new Uppercase,
            'json'                      => new Json,
            'digits'                    => new Digits,
            'digits_between'            => new DigitsBetween,
            'defaults'                  => new Defaults,
            'default'                   => new Defaults, // alias of defaults
            'nullable'                  => new Nullable,
        ];

        foreach ($baseValidator as $key => $validator) {
            $this->setValidator($key, $validator);
        }
    }

    /**
     * Given $ruleName and $rule to add new validator
     */
    public function addValidator(string $ruleName, Rule $rule): void
    {
        if (!$this->allowRuleOverride && array_key_exists($ruleName, $this->validators)) {
            throw new RuleQuashException(
                "You cannot override a built in rule. You have to rename your rule"
            );
        }

        $this->setValidator($ruleName, $rule);
    }

    /**
     * Set rule can allow to be overrided
     */
    public function allowRuleOverride(bool $status = false): void
    {
        $this->allowRuleOverride = $status;
    }

    /**
     * Set this can use humanize keys
     */
    public function setUseHumanizedKeys(bool $useHumanizedKeys = true): void
    {
        $this->useHumanizedKeys = $useHumanizedKeys;
    }

    /**
     * Get $this->useHumanizedKeys value
     */
    public function isUsingHumanizedKey(): bool
    {
        return $this->useHumanizedKeys;
    }
}

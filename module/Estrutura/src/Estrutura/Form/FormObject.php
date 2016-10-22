<?phpnamespace Estrutura\Form;use Estrutura\Form\Element\Combo;use Estrutura\Form\Element\Cpf;use Estrutura\Form\Element\Float;use Estrutura\Form\Element\Vetor;use Zend\Form\Element\Hidden;use Zend\Form\Element;use Zend\InputFilter\InputFilter;use Zend\Captcha\Image as CaptchaImage;class FormObject {    const TIPO_TEXT = 'Text';    const TIPO_CPF = '\Estrutura\Form\Element\Cpf';    const TIPO_DATE = 'Date';    const TIPO_HIDDEN = 'Hidden';    const TIPO_EMAIL = 'Email';    protected $namespace;    /**     * @var AbstractForm     */    protected $form;    protected $elements = [];    /**     * @param $name     * @return FormElement     * @throws \Exception     */    public function get($name) {        if (!array_key_exists($name, $this->elements)) {            throw new \Exception("Elemento $name não encontrado.");        }        return $this->elements[$name];    }    /**     *     * @param string $namespace     * @param \Estrutura\Form\AbstractForm $form     * @param \Zend\InputFilter\InputFilter $inputFilter     */    public function __construct($namespace, AbstractForm $form, \Zend\InputFilter\InputFilter $inputFilter) {        $this->namespace = $namespace;        $this->form = $form;        $this->inputFilter = $inputFilter;    }    /**     * @param Element $element     * @return FormElement     */    public function add(Element $element) {        $name = $element->getName();        if (!isset($this->elements[$name])) {            $element->setAttributes(array(                'id' => $name,                'class' => 'form-control',            ));            $this->inputFilter->add(['name' => $element->getName(), 'required' => false]);            $formElement = new FormElement($element, $this->inputFilter);            $this->form->add($element);            $this->elements[$name] = $formElement;        }        return $this->elements[$name];    }    /**     * @param $name     * @return FormElement     */    public function hidden($name) {        return $this->add(new Hidden($name));    }    /**     * @param $name     * @return FormElement     */    public function date($name) {        $element = $this->add(new Element\Text($name));        $element->setAttribute('data-mask', '00/00/0000');        $element->setAttribute('data-date-format', 'DD/MM/YYYY');        return $element;    }    public function hora($name) {        $element = $this->add(new Element\Text($name));        $element->setAttribute('hora-mask', '00:00:00');        $element->setAttribute('hora-date-format', 'HH:mm:ss');        return $element;    }    /**     * @param $name     * @return FormElement     */    public function dateTime($name) {        $element = $this->add(new Element\Text($name));        $element->setAttribute('data-mask', '00/00/0000 00:00:00');        $element->setAttribute('data-date-format', 'DD/MM/YYYY HH:mm:ss');        return $element;    }    /**     * @param $name     * @return FormElement     */    public function captcha($name) {        $dirdata = BASE_PATCH . '/data';        //pass captcha image options        $captchaImage = new CaptchaImage(array(                'font' => BASE_PATCH . '/vendor/dompdf/dompdf/lib/fonts/DejaVuSerif.ttf',                'width' => 250,                'height' => 100,                'dotNoiseLevel' => 40,                'lineNoiseLevel' => 3)        );        $captchaImage->setImgDir($dirdata . '/captcha');        $captchaImage->setImgUrl('/auth/captcha/');        $captcha = new Element\Captcha($name);        $captcha->setOptions([            'label' => 'Verificação de segurança',            'captcha' => $captchaImage,        ]);        $element = $this->add($captcha);        $element->setAttribute('title', 'Digite o texto conforme mostrado acima');        return $element;    }    /**     * @param $name     * @param $service     * @param string $chave     * @param string $valor     * @param string $metodo     * @param array $params     * @return FormElement     */    public function combo($name, $service, $chave = 'id', $valor = 'nome', $metodo = 'fetchAll', $params = []) {        $element = $this->add(new Combo($name));        $element->setOptions([            'service' => $service,            'chave' => $chave,            'valor' => $valor,            'metodo' => $metodo,            'params' => $params        ]);        $element->setAttribute('data-ng-options', "k as v for (k,v) in arr" . ucfirst($name));        $element->setAttribute('data-source', "arr" . ucfirst($name));        return $element;    }    /**     *     * @param type $name     * @param type $valueOption     * @return FormElement     */    public function select($name, $valueOption = []) {        $element = $this->add(new Element\Select($name));        $element->setOptions(['value_options' => $valueOption]);        $element->setAttribute('data-ng-options', "k as v for (k,v) in arr" . ucfirst($name));        $element->setAttribute('data-source', "arr" . ucfirst($name));        return $element;    }    /**     *     * @param type $name     * @param type $valueOption     * @return FormElement     */    public function radioxxx($name, $valueOption = []) {        $element = $this->add(new Element\Radio($name));        $element->setOptions(['value_options' => $valueOption]);        $element->setAttribute('class', 'pop');        return $element;    }    /**     *     * @param type $name     * @param type $valueOption     * @return FormElement     */    public function radio($name, $valueOption = []) {        if (!isset($this->elements[$name])) {            $element = new Element\Radio($name);            $this->inputFilter->add(                [                    'name' => $element->getName(),                    'required' => false                ]            );            $formElement = new FormElement($element, $this->inputFilter);            $this->form->add($element);            $this->elements[$name] = $formElement;        }        $elementAux = $this->elements[$name];        $elementAux->setOptions([            'value_options' => $valueOption,            'label_attributes' => [                'class' => 'radio-inline'            ],        ]);        return $elementAux;    }    /**     * @param $name     * @param array $valueOption     * @param bool $character_value | TRUE: Valor do Combo como [S] ou [N] | FALSE: Valor do Combo como [1] ou [0]     * @return FormElement     */    public function checkbox($name, $valueOption = [], $character_value = false) {        $element = $character_value ? $this->add(new Element\CheckboxCharacter($name)) : $this->add(new Element\Checkbox($name));        $element->setOptions(['value_options' => $valueOption]);        $element->setAttribute('class', 'pop');        return $element;    }    /**     *     * @param type $name     * @param type $valueOption     * @return FormElement     */    public function multicheckbox($name, $valueOption, $classeCss = 'checkbox-inline') {        if (!isset($this->elements[$name])) {            $element = new Element\MultiCheckbox($name);            $this->inputFilter->add(                [                    'name' => $element->getName(),                    'required' => false                ]            );            $formElement = new FormElement($element, $this->inputFilter);            $this->form->add($element);            $this->elements[$name] = $formElement;        }        $elementAux = $this->elements[$name];        $elementAux->setOptions([            'value_options' => $valueOption,            'label_attributes' => [                'class' => $classeCss            ],        ]);        return $elementAux;    }    /**     * @param $name     * @param null $label     * @return FormElement     */    public function text($name) {        $element = $this->add(new Element\Text($name));        $element->addTextValidatorsAndFilters();        return $element;    }    public function urgency($name) {        $element = $this->add(new Element\Select($name));        $element->setOptions(['value_options' => ['Selecione', 'Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta']]);        return $element;    }    public function severity($name) {        $element = $this->add(new Element\Select($name));        $element->setOptions(['value_options' => ['Selecione', 'Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta']]);        return $element;    }    public function relevance($name) {        $element = $this->add(new Element\Select($name));        $element->setOptions(['value_options' => ['Selecione', 'Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta']]);        return $element;    }    /**     * @param $name     * @param null $label     * @return FormElement     */    public function money($name) {        $element = $this->add(new Element\Text($name));        $element->setAttribute('data-mask', 'money');        $element->addFilter('Estrutura\Filter\Decimal');        return $element;    }    /**     * @param $name     * @param null $label     * @return FormElement     */    public function password($name) {        $element = $this->add(new Element\Password($name));        $element->setAttribute('data-minlength', '8');        $element->setAttribute('data-minlength-error', 'Mínimo 8 caracteres');        return $element;    }    /**     * @param $name     * @param null $label     * @return FormElement     */    public function file($name, $multiple = false) {        $element = $this->add(new Element\File($name));        $element->setAttribute('class', '')            ->setAttribute('multiple', $multiple);        return $element;    }    /**     * @param $name     * @return FormElement     */    public function collection($name, $tipoElemento = null) {        if (!$tipoElemento)            $tipoElemento = new Element\Text();        $element = $this->add(new Vetor($name, [ 'target_element' => $tipoElemento]));        return $element;    }    /**     *     * @param type $name     * @return FormElement     */    public function textarea($name) {        $element = $this->add(new Element\Textarea($name));        $element->addTextValidatorsAndFilters();        return $element;    }    /**     *     * @param type $name     * @return FormElement     */    public function textareaHtml($name) {        $element = $this->add(new Element\Textarea($name));        //$element->addTextValidatorsAndFilters();        return $element;    }    /**     * @param $name     * @param null $label     * @return FormElement     */    public function cpf($name) {        $element = $this->add(new Cpf($name));        $element->setAttribute('data-mask', '000.000.000-00');        $element->setAttribute('data-mask-reverse', 'true');        $element->setAttribute('pattern', '^\d{3}\.\d{3}\.\d{3}\-\d{2}$');        $element->setAttribute('data-error', 'CPF inválido.');        $element->addValidator('\Estrutura\Validator\Cpf');        $element->addFilter('Estrutura\Filter\Cpf');        return $element;    }    /**     * @param $name     * @param null $label     * @return FormElement     */    public function telefone($name) {        $element = $this->add(new Element\Text($name));        $element->setAttribute('data-mask', '(00) 0000-00009');        $element->setAttribute('pattern', '^\([1-9][0-9]\) [2-9]{1}[2-9]{1}[0-9]{2}-[0-9]{5}|\([1-9][0-9]\) [2-9]{1}[0-9]{3}-[0-9]{4}$');        $element->setAttribute('data-error', 'Telefone inválido.');        return $element;    }    /**     * @param $name     * @param null $label     * @return FormElement     */    public function cnpj($name) {        $element = $this->add(new Element\Text($name));        $element->setAttribute('data-mask', '00.000.000/0000-00');        $element->setAttribute('data-mask-reverse', 'true');        $element->setAttribute('pattern', '^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$');        $element->setAttribute('data-error', 'CNPJ inválido.');        $element->addValidator('Estrutura\Validator\Cnpj');        $element->addFilter('Estrutura\Filter\Cpf');        $element->addTextValidatorsAndFilters();        return $element;    }    /**     * @param $name     * @param null $label     * @return FormElement     */    public function email($name) {        $element = $this->add(new Element\Email($name));        $element->setAttribute('data-error', 'Endereço de e-mail inválido.');        $element->addTextValidatorsAndFilters();        $element->addValidator('\Estrutura\Validator\EmailAddress', ['domain' => false, 'useMxCheck' => false]);        return $element;    }    /**     * @param $name     * @return FormElement     */    public function float($name) {        $element = $this->add(new Float($name));        $element->addFilter('Estrutura\Filter\Decimal');        return $element;    }    /**     * @param $name     * @param $label     * @return FormElement     */    public function submit($name, $label) {        $element = $this->add(new Element\Submit($name));        $element->value($label);        return $element;    }    /**     * @param $name     * @param $size     * @return FormElement     */    public function number($name, $size) {        $elemenet = $this->add(new Element\Text($name));        $elemenet->addFilter('Estrutura\Filter\Decimal');        $elemenet->mask('' . number_format(str_repeat('9', $size), 0, ',', '.') . '');        $elemenet->maxLength($size);        return $elemenet;    }    /**     * @param $name     * @return FormObject     */    public function subForm($name) {        $form = new AbstractForm($name);        $this->inputFilter->add(['name' => $form->getName(), 'required' => false]);        $formElement = new FormElement($form, $this->inputFilter);        $this->form->add($form);        $this->elements[$name] = $formElement;        $inputFilter = new InputFilter();        $objForm = new \Estrutura\Form\FormObject('cadastrarUsuario-' . $name, $form, $inputFilter);        return $objForm;    }    /**     * @param $name     * @return FormElement     */    public function cep($name) {        $element = $this->add(new Element\Text($name));        $element->setAttribute("data-mask", '00.000-000');        $element->setAttribute('pattern', '^[0-9]{2}.[0-9]{3}-[0-9]{3}$');        $element->setAttribute('data-error', 'Cep inválido.');        $element->addFilter('\Estrutura\Filter\Cep');        $element->addValidator('\Estrutura\Validator\Cep');        return $element;    }    /**     * @param $name     * @return FormElement     */    public function integer($name) {        $element = $this->add(new Element\Number($name));        $element->addValidator('\Estrutura\Validator\Number');        $element->addFilter('StringTrim');        return $element;    }    public function cpfCnpj($name) {        $element = $this->add(new Element\Text($name));        $element->setAttribute('pattern', '(^\d{3}\.\d{3}\.\d{3}\-\d{2}$)|(^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$)');        $element->setAttribute('data-error', 'CPF/CNPJ inválido.');        $element->addValidator('\Estrutura\Validator\CpfCnpj');        return $element;    }}
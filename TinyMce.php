<?php

namespace iensys\tinymce;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class TinyMce extends InputWidget
{
    /**
     * @var string the language to use. Defaults to null (en).
     */
    public $language;

    /**
     * @var array the options for the TinyMCE JS plugin.
     * Please refer to the TinyMCE JS plugin Web page for possible options.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
    public $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $view = $this->getView();

        TinyMceAsset::register($view);

        $id = $this->options['id'];

        $this->clientOptions['selector'] = "#$id";
        if ($this->language !== null) {
            $this->clientOptions['language'] = $this->language;
        }

        $options = Json::encode($this->clientOptions);

        $view->registerJs("tinymce.init($options);");
    }
} 
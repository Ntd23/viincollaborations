<?php

namespace Theme\Infinia\Forms;

use Botble\Base\Forms\FieldOptions\CoreIconFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\CoreIconField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Forms\ShortcodeForm as BaseShortcodeForm;

class ShortcodeForm extends BaseShortcodeForm
{
    public function addButtonActions(array $names = [], array $wrapperAttributes = []): static
    {
        $names = $names ?: ['primary' => __('Primary')];

        foreach ($names as $key => $label) {
            $this
                ->addOpenFieldset("{$key}_action", $wrapperAttributes)
                ->add(
                    "{$key}_action_label",
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__(':label action label', ['label' => $label]))
                )
                ->add(
                    "{$key}_action_url",
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__(':label action URL', ['label' => $label]))
                )
                ->add(
                    "{$key}_action_icon",
                    CoreIconField::class,
                    CoreIconFieldOption::make()
                        ->label(__(':label action icon', ['label' => $label]))
                )
                ->addCloseFieldset("{$key}_action");
        }

        return $this;
    }
}

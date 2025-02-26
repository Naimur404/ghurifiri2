<?php

namespace Botble\PostCollection\Forms;

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\PostCollection\Http\Requests\PostCollectionRequest;
use Botble\PostCollection\Models\PostCollection;

class PostCollectionForm extends FormAbstract
{
    /**
     * {@inheritDoc}
     */
    public function setup(): void
    {
        $this
            ->model(new PostCollection())
            ->setValidatorClass(PostCollectionRequest::class)
            ->withCustomFields()
            ->add(
                'name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('core/base::forms.name'))
                    ->placeholder(trans('core/base::forms.name_placeholder'))
                    ->required()
                    ->maxLength(120)
                    ->toArray()
            )
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->colspan(4)->maxLength(400)->toArray())
            ->addMetaBoxes([
                'with_related' => [
                    'title' => '',
                    'content' => '<div class="wrap-posts-relations" data-target="' . route(
                        'posts-collection-relations',
                        ['collection_id' => $this->getModel()->id]
                    ) . '"></div>',
                    'wrap' => false,
                    'priority' => 9999,
                ],
            ])
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->add('image', MediaImageField::class)
            ->setBreakFieldPoint('status');
    }
}

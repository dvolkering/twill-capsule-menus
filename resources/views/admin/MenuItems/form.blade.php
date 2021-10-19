@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'internal-links', 'label' => 'Internal Item'],
        ['fieldset' => 'external-links', 'label' => 'External Link'],
        ['fieldset' => 'link-to-list', 'label' => 'Link to Listing Item'],
    ]
])

@section('contentFields')
    @formField('input', [
    'name' => 'description',
    'label' => 'Description',
    'maxlength' => 100
    ])

    @formField('browser', [
    'label' => 'Menu',
    'max' => 1,
    'routePrefix' => false,
    'moduleName' => 'menus',
    'name' => 'menu'
    ])

@stop

@section('fieldsets')
    @formFieldset(['id' => 'internal-links', 'title' => 'Internal Item'])
    @formField('browser', [
    'modules' => config('twill.linkable'),
    'name' => 'related_menu',
    'note' => 'Page, Article...',
    'label' => 'Internal Item'
    ])
    @endformFieldset


    @formFieldset(['id' => 'external-links', 'title' => 'External Link'])
    @formField('input', [
    'name' => 'url',
    'label' => 'External Link',
    'maxlength' => 100
    ])

    @formField('select', [
    'name' => 'link_target',
    'label' => 'Cible',
    'default' => '_parent',
    'options' => [
    [
    'value' => '_parent',
    'label' => 'Open link in the same tab/window'
    ],
    [
    'value' => '_blank',
    'label' => 'Open link in a new tab/window'
    ],
    ]
    ])
    @endformFieldset

    @formFieldset(['id' => 'link-to-list', 'title' => 'Link to Listing Item'])
    @formField('select', [
    'name' => 'route_path',
    'label' => 'Link to Listing Item',
    'options' => $routes
    ])

    @formField('input', [
    'name' => 'params',
    'label' => 'Params',
    'note' => '/params1/params2'
    ])
    @endformFieldset
@stop

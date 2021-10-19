@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => $titleFormKey === 'title' ? twillTrans('twill::lang.modal.title-field') : ucfirst($titleFormKey),
    'translated' => $translateTitle ?? false,
    'onChange' => 'formatPermalink'
])

@formField('input', [
    'name' => 'description',
    'label' => 'Description'
])


@if ($permalink ?? true)
    @formField('input', [
    'name' => 'slug',
    'label' => twillTrans('twill::lang.modal.permalink-field'),
    'translated' => true,
    'ref' => 'permalink',
    'prefix' => $permalinkPrefix ?? ''
    ])
@endif

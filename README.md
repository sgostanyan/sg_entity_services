# SG Entity Services

SG Entity Services is a PHP api for dealing Drupal development.

## SgEntityStorageManager

 ### getEntities(string $entityType, array $bundles = NULL, array $ids = NULL) :

Return entities from given parameters.

__$entitytype__: entity type id

__$bundles__: desired entity bundles (optional)

__$ids__: filtering for given ids (optional)

Usage:
```bash
Drupal::service('sg_entity_services.service')->getEntityStorageManager()->getEntities('node', ['article', 'event']);
```

### createEntity(string $entityType, array $values, array $translations = NULL) :

Creates entity and translations (optional)

__$entitytype__: entity type id

__$values__: fields array

__$translations__: fields for translations (optional)

Usage:
```bash

$fieldValues = [
    'title' => 'Title',
    'body' => [
      'value' => 'summary text',
    ],
    'field_tags' => [
      [
        'target_id' => 1,
      ],
    ],
  ];

$translationsValues = [
    'en' => [
      'title' => 'EN title',
      'body' => [
        'value' => 'English summary',
      ],
      'field_tags' => [
        [
          'target_id' => 1,
        ],
      ],
    ],
    'es' => [
      'title' => 'ES title',
      'body' => [
        'value' => 'Spanish summary',
      ],
      'field_tags' => [
        [
          'target_id' => 1,
        ],
      ],
    ],
  ];

Drupal::service('sg_entity_services.service')->getEntityStorageManager()->createEntity('node', $fieldValues, $translationsValues);

```

 ### addTranslations(EntityInterface $entity, array $translations) :

Add translation for a given entity.

__$entity__: entity interface

__$translations__: fields for translations

Usage:
```bash
Drupal::service('sg_entity_services.service')->getEntityStorageManager()->getEntities('node', ['article', 'event']);
```

## SgEntityDisplayManager

 ###  getViewModes(string $entityType) :

 Gives a list of available view modes for a given entity type.

 __$entityType__: entity type

 Usage:
 ```bash
$viewModes = $sgEntityService->getEntityDisplayManager()->getViewModes('node');
 ```
 ###  renderEntity(EntityInterface $entity, $viewMode = NULL) :

 Gives a render array for a given entity.

 __$entity__: entity interface

 __$viewMode__: view mode

 Usage:
 ```bash
  $renderArray = $sgEntityService->getEntityDisplayManager()->renderEntity($entity, 'teaser'));
 ```

 ###  renderArrayToMarkup(array $renderArray) :

 Gives a Markup object for a given render array.

 __$renderArray__: render array

 Usage:
 ```bash
  $renderArray = $sgEntityService->getEntityDisplayManager()->renderEntity($entity, 'teaser'));
  $markup = $sgEntityService->getEntityDisplayManager()->renderArrayToMarkup($renderArray);
 ```

###  htmlTagRender($tag, $value, array $attributes = []) :

 Gives a Markup object for a given render array.

 __$tag__: html tag type

 __$value__: html tag's value

__$attributes__: array of html attributes

 Usage:
 ```bash
   $tag = $sgEntityService->getEntityDisplayManager()->htmlTagRender('a', 'Drupal', ['href' => 'https://drupal.org']);
 ```

## License
[MIT](https://choosealicense.com/licenses/mit/)

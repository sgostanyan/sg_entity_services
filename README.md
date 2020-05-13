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

## License
[MIT](https://choosealicense.com/licenses/mit/)

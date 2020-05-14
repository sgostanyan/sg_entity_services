# SG Entity Services

SG Entity Services is a Drupal service for dealing with Drupal entities.

## SgEntityStorageManager

 ### getEntities(string $entityType, array $bundles = NULL, array $ids = NULL) :

Return entities from given parameters.

__$entityType__: entity type id

__$bundles__: desired entity bundles (optional)

__$ids__: filtering for given ids (optional)

Usage:
```bash
Drupal::service('sg_entity_services.service')->getEntityStorageManager()->getEntities('node', ['article', 'event']);
```

### createEntity(string $entityType, array $values, array $translations = NULL) :

Creates an entity with translations (optional)

__$entityType__: entity type id

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

Add translations for an existing entity.

__$entity__: entity interface

__$translations__: fields for translations

Usage:
```bash
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
$entity = Drupal::entityTypeManager()->getStorage('node')->load(46);
$entity = Drupal::service('sg_entity_services.service')->getEntityStorageManager()->addTranslations($entity, translationsValues);
```

## SgEntityDisplayManager

 ###  getViewModes(string $entityType) :

 Return a list of available view modes for a given entity type.

 __$entityType__: entity type

 Usage:
 ```bash
$viewModes = Drupal::service('sg_entity_services.service')->getEntityDisplayManager()->getViewModes('node');
 ```
 ###  renderEntity(EntityInterface $entity, $viewMode = NULL) :

 Return a render array for a given entity.

 __$entity__: entity interface

 __$viewMode__: view mode

 Usage:
 ```bash
  $renderArray = Drupal::service('sg_entity_services.service')->getEntityDisplayManager()->renderEntity($entity, 'teaser'));
 ```

 ###  renderArrayToMarkup(array $renderArray) :

 Return a Markup object for a given render array.

 __$renderArray__: render array

 Usage:
 ```bash
  $renderArray = Drupal::service('sg_entity_services.service')->getEntityDisplayManager()->renderEntity($entity, 'teaser'));
  $markup = Drupal::service('sg_entity_services.service')->getEntityDisplayManager()->renderArrayToMarkup($renderArray);
 ```

###  htmlTagRender($tag, $value, array $attributes = []) :

 Return a render array for a given tag element.

 __$tag__: html tag type

 __$value__: html tag's value

__$attributes__: array of html attributes

 Usage:
 ```bash
   $tag = Drupal::service('sg_entity_services.service')->getEntityDisplayManager()->htmlTagRender('a', 'click here', ['href' => 'https://drupal.org']);
 ```

## SgFileManager

 ###  generateFileEntity($source, $filename, $destination = 'public://') :

 Create a file entity and returns the file id.

 __$source__: source folder (end slash is required)

 __$filename__: name of file

 __$destination__: file destination, can be 'public://' or 'private://' (default is public://). It can include subfolders, end slash is required

 Usage:
 ```bash
$fid = Drupal::service('sg_entity_services.service')->getFileManager()->generateFileEntity('public://sources/', 'tiger.jpg', 'private://animals/');
 ```

 ###  getFileInfos($fid) :

 Return an array of file details: mime type, size, absolute url, relative url, internal url, system path, file usage.

 __$fid__: file id.

 Usage:
 ```bash
$fileInfos = Drupal::service('sg_entity_services.service')->getFileManager()->getFileInfos(298);
 ```

 ###  sanitizeFileSize($size) :

 Return a formated file size.

 __$size__: file size in bytes.

 Usage:
 ```bash
$fileInfos = Drupal::service('sg_entity_services.service')->getFileManager()->sanitizeFileSize(286567);
 // return "287 Ko".
 ```

## License
[MIT](https://choosealicense.com/licenses/mit/)

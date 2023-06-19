# I'm a Lazy ass typist
```
alias drc=docker-compose
alias gs='git status'
```

# shell into Drupal container
```
docker exec -it my_drupal9_project_php /bin/bash
```

# Edit the settings file (in the PHP container)
```
vi web/sites/default/settings.php
```

# Add the gitpod.io trusted host pattern. (in the php container)
```
$settings['trusted_host_patterns'] = array(
  '.*\.gitpod\.io$',  '\.localhost$', '\.local$', '\.loc$'
);
```

# Shell into Mautic container
```
docker exec -it my_drupal9_project_mautic /bin/bash
```

# Clear the mautic cache (in the mautic container)
```
rm -rf var/cache/*
```

# Installing modules in Drupal (after shelling to php)
```
composer require drupal/unomi:2.x-dev
composer require drupal/dropsolid_personalisation:1.x-dev
composer require drupal/mautic_paragraph:^1.0@beta
composer require drupal/asset_injector
composer require drupal/metatag
composer require drupal/admin_toolbar
composer require drupal/chosen
composer require drupal/ctools
composer require drupal/devel
composer require drupal/field_group
composer require drupal/maxlength
composer require drupal/pathauto
composer require drupal/redirect
composer require drupal/webform
composer require drupal/better_exposed_filters
composer require drupal/views_data_export
composer require drupal/epp
composer require drupal/devel
entity_reference_exposed_filters
composer require cweagans/composer-patches

  ```

        "enable-patching": true,
        "patches": {
            "drupal/core": {
                "views references 3347343": "https://www.drupal.org/files/issues/2022-12-14/drupal-views-entity-reference-filter-2429699-521.patch"
            }
         },


               "drupal/core": {
                "Datepatch": "https://www.drupal.org/files/issues/2022-10-31/2648950-265_1.patch"
            }


# Config for Personalisation
 HOST:         unomi-004.dropsolid-sites.com
 PORT:         443
 client id:    a9178f26-e7bd-443c-9a47-9ac091bb407e

# Config for Metatag
META-TAG -> edit Node
```
[node:field_recipe_category], [node:field_tags]
```
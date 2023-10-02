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

# composer require the modules:

composer require drupal/ctools
composer require drupal/devel
composer require drupal/key
composer require drupal/admin_toolbar
composer require 'drupal/openai:^1.0@alpha'
composer require 'drupal/chatgpt_plugin:^2.1'
composer require 'drupal/openai_ckeditor'
composer require 'drupal/openai_content'
composer require 'drupal/chatgpt_plugin'
composer require 'drupal/openai_images:^2.1'
composer require 'drupal/ai_image:^1.0@beta'


Backup
======
This ELGG plugin provides backup and restore functionality for deleted objects and annotations. It backups deleted entities in serialized form into a seperate table.

## Features
* backup and restore deleted objects and annotations
* deleted objects and annotations are grouped by transactions, this allows to restore a recursive deletion at once

## Installation
Install the plugin by copying it to mod/ and then enable it through the admin interface.

## Todo
* Backup and restore for ElggFile objects.
* Cronjob to remove old backups.
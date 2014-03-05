#tomkyle/rbac

This is my role-based access control solution, extracted from my legacy codebase.

##Core concepts


###Roles

A client may be associated with certain roles, e.g. *Authors* or *Admins*. 
These are stored in a `RolesStorage` object that contains role IDs.

```php
//namespace stuff truncated...
$roles = new RolesStorage( 1, 2 );
echo $roles->contains( 2 ) ? "TRUE" : "NO";
```

###ACL
A service may be restricted to certain roles. 
`AccessControlList` as an extension of `RolesStorage` will do that:

```php
//namespace stuff truncated...

class MyUser implements RolesAwareInterface {
  use RolesAwareTrait;
}

class MyService implements AccessControlListAwareInterface {
  use AccessControlListAwareTrait;
}

$service = new MyService;

$user = new MyUser;
$user->setRoles( new RolesStorage( 1, 2 ) );

echo $service->isAllowed( $user ) ? "TRUE" : "NO";
```


###Permissions
A client may be allowed or disallowed to do certain things. 
`PermissionsStorage` will do that:

```php
//namespace stuff truncated...

class MyUser implements PermissionsAwareInterface {
  use PermissionsAwareTrait;
}

$user = new MyUser;
new ApplyPermissionsStorage( $user );
echo $user->hasPermission( "my_action" ) ? "TRUE" : "NO";
```



##Installation

This library has no dependencies except a PDO connection. Install from command line or `composer.json` file:

#####Command line
    
    composer require tomykle/rbac

#####composer.json

    "require": {
        "tomkyle/rbac": "dev-master"
    }

#####MySQL
TBD: I'll prepare and deliver a MySQL dump as soon as possible.



##Database
Roles, Permissions and their respective associations to clients are stored in a bunch of database tables: 

| Table  | Description |
| :----- | :---------- |
| tomkyle_roles | Defines all roles (aka *user groups*) the application works with. |
| tomkyle_permissions | Holds  permissions the application works with.|
| tomkyle_permissions_roles_mm | Associates permissions with one or many roles. |
| tomkyle_clients_roles_mm | Associates a client with one or many roles.|
| tomkyle_clients_rights_adjust | Adjusts a clients' permissions, overriding the ones he is granted or permitted due to his roles |

##Administration
Sorry, currently there is no administration tool available. I used to manage them manually in the database…

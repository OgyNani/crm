# CRM

## ACL - Access Control Level

- Roles - Sales, Manager, Admin...
- Resource - User list, Clients list, Orders...
- Permissions - Sales can manage Orders, Sales can't manage Users

## Run

```
$ symfony serve:start
```

## Run migrations

```
$ ./bin/console doctrine:migration:migrate
```

## Roadmap
  
 - [x] Create /client/{id}/edit page
 - [x] Update ClientEditTest
 - [ ] Fix UserCreateTest
 - [x] user/profile error with field role.name
 - [ ] fix all tests
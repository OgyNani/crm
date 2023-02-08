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
  
 - [ ] Create client_comments table (id, client_id, user_id, creation_at, text)
 - [ ] Create order_comments table (id,  order_id,  user_id, created_at, text)
 - [ ] Create button Comments on client page (/client/{id}/profile)
 - [ ] Create endpoint /client/{id}/add-comment
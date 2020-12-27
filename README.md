## Rest Api - user endpoint

#### Развёртывание проекта:

1. Из корня выполнить команду: 
    `docker-compose up`
2. После того как `test_db` напишет что `mysqld: ready for connections` - можно выполнить следующую команду: 
    `docker exec -ti test_app bash -c "make"`
3. Обновить файл hosts и добавить строку 
   ```
   127.0.0.1    api.test.local
   ```
   (или не обновлять, а отсылать запрос на 12.0.0.1 и указывать api.test.local в хедере Host)
   

#### Данные для подключения к бд:

```
адрес: 127.0.0.1
логин: awwar
пароль: letmein
```

#### Коллекция постмена уже в проекте:

Файл называется ```test_api.postman_collection.json```

Если после отправки запроса приходят сообщения "Your request was made with invalid credentials." - то нужно залезть в 
бд и использовать auth_key любого юзера с status = 10.

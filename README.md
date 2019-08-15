# CuwIdi - Come Up With Ideas & Done It 
### CuwIdi - сайт на котором можно выложить идеи и комментировать(помогать реализовывать) их 
#### CuwIdi состоит из двух основных структур идеи и пользователи. 
    Идея включает в себя: название идеи, краткое и полное описание, изображений, тэгов и комментариев.
    У пользователей есть: имя, логин, пароль, профильное изображение, информация.
        Пользователи могут создавать идеи и комментировать их. 
#### Страницы: 
##### Главная страница - выводится пять последних идей 
##### Страница идей - выводится список идей.
    На этой странице есть поиск и создание идеи. 
##### Страница идеи - выводится идея: название, краткое и полное описание, тэги, изображения и комментарии. 
    Для создателя идеи предусмотрено изменение и добавление элементов идеи. 
##### Страница тэгов - выводится список тэгов, со ссылками на страницы тэгов.
##### Страница тэга - выводится все идеи у которых в тэгах указан данный тэг.
##### Страница пользователей - выводится список пользователей.
##### Страница профиля пользователя — выводится профиль пользователя.
    На странице профиля предоставляется, информация, аватарка, идеи и комментарии пользователя.
##### Страница редактирования профиля пользователя - предоставляется возможность изменить информацию о пользователя, удалить или заморозить аккаунт.
##### Страница поиска — выводится результаты поиска по запросу составленному пользователем в поле поиска.
    Поиск происходит среди идей, пользователей и комментариев.
#### Возможности по состоянию пользователя:
##### Любой пользователь может просматривать идеи, профили, комментарии и тэги.
##### Зарегистрированный пользователь может: создавать идеи, редактировать свои идеи, удалять свои комментарии и идеи, редактировать, удалять или замораживать свой аккаунт.
##### Администратор может: редактировать или удалять любые идеи, удалять все комментарии, идеи, тэги и аккаунты, замораживать аккаунты.
##### Замороженый пользователь может разморозить свой аккаунт, если пользователь заморозил его сам, иначе может обратиться по форме связи к администраторам.
#### Использованные модули:
##### HTTP - Apache-PHP-7
##### PHP - PHP-7.1
##### MySQL/MariaDB - MySQL-5.6
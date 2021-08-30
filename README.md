## Installation

```
composer install
cp .env.example .env        // you can set SLACK_WEBHOOK_URL if desired, otherwise default is one provided.
php artisan key:generate
```


- [x] A user can add people
- [x] A user can connect people together as families
- [x] A user can see a family tree to any particular Person in the application
- [x] Each time a new person is added, a new Notification should be dispatched to a Slack webhook. Please PM Rob on Slack for the webhook - use Laravel Notifications and this Slack notification package: https://github.com/laravel/slack-notification-channel

# Onboarding Project for Code Groovers
My first project with Laravel, and a web framework in general. Includes my solution on implementing a small Deployment Request system.

This repository my solution for a simple [Laravel](laravel) application utilizing the [cg/forms](cg-forms) package. This will give you a good introduction to [PHP](php), Laravel, cg/forms and [Postgresql](postgresql).

The goal of the project is to create an application that allows anyone to create a Deployment Request by filling out a Deployment Request Template Form. 

The application should allow any user to:

1. See all existing filled out Deployment Requests.
2. View a particular Deployment Request.
3. Create a new Deployment Template by letting a user fill out the Deployment Template Form.
4. Delete a Deployment Request. 
5. Edit an existing Deployment Request.
6. Duplicate a Deployment Request.
6. Download a Word Document of the deployment Request.

cg/forms uses [JSON](json) declare the structure of a form. You can find the JSON file for the Deployment Request in the root of the repository as `deployment-request-form.json`.

To implement the above functionality you will need to:

1. Review Laravel [Routes](laravel-routing) & [Controllers](laravel-controllers).
2. [Blade templates](blade-templates).
2. Review [Eloquent Models](laravel-orm) (Laravel's Object Relational Mapper) used for accessing the database.
3. Load the `deployment-request-form.json` form definition into the database. You can find examples of this in the [cf/forms feature tests](https://github.com/RHUL-CS-Projects/CG_Laravel_Forms/blob/v0.1/tests/Feature/Test_View_EditForm.php#L25).

Finally we will deploy our application to https://www.heroku.com/

[laravel]: https://laravel.com/docs/5.8
[cg-forms]:
[php]:
[postgresql]:
[json]:
[laravel-routing]: https://laravel.com/docs/5.8/routing#basic-routing
[laravel-controllers]: https://laravel.com/docs/5.8/controllers#defining-controllers
[blade-templates]: https://laravel.com/docs/5.8/blade
[laravel-orm]: https://laravel.com/docs/5.8/eloquent#retrieving-models
[heroku]:

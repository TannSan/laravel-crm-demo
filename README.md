# Laravel CRM Demo
This simple Laravel CRM Demo is written using Laravel 5.8 and AdminLTE 3.  Once you are authenticated you can see three areas:

- Companies: View, add, edit and delete companies
- Employees: View, add, edit and delete employees
- Dashboard: View reports about companies and their employees

## Requirements
- GD Library >= 2.0 or Imagick PHP extension >= 6.5.7
- Fileinfo Extension (for Intervention Image package)

## Installation
- Download latest source from https://github.com/TannSan/laravel-crm-demo
- Create a database
- Create a copy of `.env.example` called `.env`
- Update the APP_URL, database and email fields to match those of your server
- `npm install`
- `composer update`
- `php artisan key:generate`
- `php artisan storage:link`
- `php artisan migrate:fresh --seed`
- `vendor/bin/phpunit`

## Features
- All pages fully mobile responsive
- Realistic seed data
- Uses request validation
- Search filter for Companies and Employees
- Top and bottom mobile responsive table pagination
- Delete confirmation
- PHPUnit testing
- Error feedback
- Separate language file so it's ready for translation
- Themed auth pages (registration disabled)
- Resizes uploaded company logo images
- Chart.js Bar Chart so you can see the see the number of employees at each company
- Full flock of favicons!

## Future Improvements
- Enable column sorting for tables
- Create user management system
- Create method to edit user profile
- Toast notifications after actions e.g. "Company Saved"
- Fix the min-height bug with AdminLTE 3 so can sticky the footer
- Decide if it's best to force reloading of all the logos using a fake querystring e.g. red-house.jpg?no-cache=1245126771 - Will slow overall loading but will mean pictures always update instead of displaying old logo until a cache refresh
- Make the list of employees on the view/edit company pages interactive

## Attributions
- Laravel 5.8: https://laravel.com
- AdminLTE 3: https://adminlte.io/themes/dev/AdminLTE/
  - `npm install admin-lte@v3.0.0-alpha.2 --save`
- Boostrap Confirmation Box Used For Deletions: https://github.com/mistic100/Bootstrap-Confirmation
- Dashboard Chart: https://github.com/chartjs/Chart.js
- FavIcon Generator: https://realfavicongenerator.net
- Image Resizing & Saving: http://image.intervention.io
- Smiling Rubber Ducky Icon: https://www.vecteezy.com/vector-art/89698-cute-rubber-duck-icons-set
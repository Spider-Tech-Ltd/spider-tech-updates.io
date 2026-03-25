# Project MVC Structure Documentation

The project has been refactored from vanilla PHP into a modern Model-View-Controller (MVC) architecture.

## Folder Structure

- `config/`: Configuration files.
  - `config.php`: Central configuration, defines `ROOT_PATH` and implements an autoloader for classes.
  - `database.php`: Database connection class.
  - `db_config.php`: (Hidden/Protected) Database credentials.
- `controllers/`: Request handling and business logic.
  - `BaseController.php`: Parent controller with the `render()` method.
  - `HomeController.php`, `EventController.php`, `TrainingController.php`, etc.
- `models/`: Database interaction logic.
  - `HomeModel.php`, `EventModel.php`, `TrainingModel.php`, etc.
- `views/`: HTML templates and layouts.
  - `layout/`: Shared header and footer.
  - `home/`, `events/`, `trainings/`, `forum/`, `general/`: Module-specific templates.
- `utils/`: Helper functions and core utilities.
  - `Router.php`: Simple routing system mapping URLs to controllers.
  - `helpers.php`: Global helper functions.
- `index.php`: The Front Controller and entry point for all requests.

## Routing

The project now uses a centralized routing system. All requests are directed to `index.php` with a `route` parameter:

- Home: `/?route=home` (Default)
- Events: `/?route=events`, `/?route=events/upcoming`, `/?route=events/past`, `/?route=events/detail&id=X`
- Trainings: `/?route=trainings`, `/?route=trainings/detail&id=X`
- Forum: `/?route=forum`
- About Us: `/?route=about`
- Contact Us: `/?route=contact`
- FAQ: `/?route=faq`
- Blog: `/?route=blog`

## Major Changes

1.  **Front Controller**: Eliminated multiple entry-point PHP files in the root directory in favor of a single `index.php`.
2.  **Autoloading**: Implemented `spl_autoload_register` to automatically load classes from `models/`, `controllers/`, and `utils/`.
3.  **Layout System**: Separated header and footer into reusable layout files, reducing redundancy across views.
4.  **Security**: Database credentials moved from the connection logic into a dedicated configuration file.
5.  **Clean Paths**: Used absolute pathing based on `ROOT_PATH` to prevent "file not found" errors when nesting pages.

# CONTRIBUTION FRANK PULIDO

The model under development follows the PUBLISHER-OBSERVER design pattern. The publisher is the singleton class TaskManager. The observers ara instances of Programmer class and Project class.
General Views : Orders documents by projects in a GRID… There are 2 additional views : By PROGRESS and By KIND (both are Task instance attributes).
I have used json persistence files for classes Task, Programmer and Project. The MVC model should also be developed for MySQL and MongoDB persistence.
Architecture : I have focused on usability, scalability and designing a smooth transition between READ function and subsequent UPDATE and DELETE functions.


### NEXT

#### CRUD VIEW IN HEADER IFRAME
SWITCH CASE “TASK_STATUS” to show a button that triggers Task Progress to set to next stage (on-click setting the date)

#### FRONT END
MENU : Icons for general views (grid and column) and sticky menu.
CRUD : Consider replacing the CRUD iframe in header for a centred slide down window overlapping the body.
MODEL : Develop functions for observer class Programmer. LOGIN session variable should adapt the general views applying filters so that only Tasks belonging to Project in which Programmer takes part (either as an assigned Task or as Project Manager or both) are displayed.

#### VIEWS
User Programmer : General Views should only display active projects which has not been completed ($delivered = FALSE) and where the user participates either in a task or as ProjectManager (or both). The user views all TASKS belonging to the Project, even if it’s not assigned to him/her.
Filters : By ENUMS (User Programmer).
Super Admin : Display is nor restricted by User Programmer. Additional filters should be set.

#### PROGRAMMER (OBSERVER - LISTENER)
When logging in with user/password (NEW ATTRIBUTES) a session variable is set so that only instances of Task class belonging to a Project in which Programmer instance takes part are displayed.
The OBSERVER listening functions are still to be develop :
Receive notice of ALL CRUD CHANGES in the Tasks belonging to the Project.
Keeping a LOG of all CRUD changes made by instance Programmer.
2 LOGS : My Logs (my Tasks CRUD in any Project and all Tasks of Projects listener is part of the developers team)

#### PROJECT (OBSERVER - LISTENER)
There will be necessary to ADD an attribute : array of instances of new class LOG.
New class LOG will store the details of every CRUD action and the USER that performed such action.
Listener Programmer has access to ALL info of Project in which takes part including this attribute.

#### MODEL : NEW CLASS LOG
New class LOG will store the details of every CRUD action and the USER that performed such action.
Listener Programmer has access to ALL info of Project in which takes part including this attribute.

#### DATABASE
Projects with status DELIVERED (TRUE) are to be moved to a different database after a given time still to define. This way we are going to separate WORK-IN-PROGRESS from projects already delivered to clients speeding searches and setting different access privileges and queries.
Mongo Project : Use only one collection of projects with ALL documents nested. Any Project that has attribute $delivered = TRUE is moved to a different database. Only active projects remain in the database used by the TaskManager App.


----------------------------------------------------------------------
# PHP initial Project
Main structure of php project. Folders / files:
- **app**
  - **controllers**
  - **models**
  - **views**
- **config**
- **lib**
  - **base**
- **web**

### Usage

The web/index.php is the heart of the system.
This means that your web applications root folder is the “web” folder.

All requests go through this file and it decides how the routing of the app
should be.
You can add additional hooks in this file to add certain routes.

### Project Structure

The root of the project holds a few directories:
**/app** This is the folder where your magic will happen. Use the views, controllers and models folder for your app code.
**/config** this folder holds a few configuration files. Currently only the connection to the database.
**/lib** This is where you should put external libraries and other external files.
**/lib/base** The library files. Don’t change these :)
**/web** This folder holds files that are to be “downloaded” from your app. Stylesheets, javascripts and images used. (and more of course)

The system uses a basic MVC structure, with your web app’s files located in the
“app” folder.

#### app/controllers
Your application’s controllers should be defined here.

All controller names should end with “Controller”. E.g. TestController.
All controllers should inherit the library’s “Controller” class.
However, you should generally just make an ApplicationController, which extends
the Controller. Then you can defined beforeFilters etc in that, which will get run
at every request.

#### app/models
Models handles database interaction etc.

All models should inherit from the Model class, which provides basic functionality.
The Model class handles basic functionality such as:

Setting up a database connection (using PDO)
fetchOne(ID)
save(array) → both update/create
delete(ID)
app/views
Your view files.
The structure is made so that having a controller named TestController, it looks
in the app/views/test/ folder for it’s view files.

All view files end with .phtml
Having an action in the TestController called index, the view file
app/views/test/index.phtml will be rendered as default.

#### config/routes.php
Your routes around the system needs to be defined here.
A route consists of the URL you want to call + the controller#action you want it
to hit.

An example is:
$routes = array(
‘/test’ => ‘test#index’ // this will hit the TestController’s indexAction method.
);

#### Error handling
A general error handling has been added.

If a route doesn’t exist, then the error controller is hit.
If some other exception was thrown, the error controller is hit.
As default, the error controller just shows the exception occured, so remember
to style the error controller’s view file (app/views/error/error.phtml)


### Utilities
- [PHP Developers Guide](https://www.php.net/manual/en/index.php).
- .gitignore file configuration. [See Official Docs](https://docs.github.com/en/get-started/getting-started-with-git/ignoring-files).
- Git branches. [See Official Docs](https://git-scm.com/book/en/v2/Git-Branching-Branches-in-a-Nutshell).

# todoAPI
## A CRUD api programmed in php using the WAMP software stack's database and Apache webserver.

The api allows CRUD operations for both users and tasks. With a server running in localhost, use POSTMAN or browser url to 
execute api calls.

## Available User Calls
- http://localhost/api/postuser.php Params(email, password, username)
- http://localhost/api/getSingleUser.php Params(email, password)
- http://localhost/api/updateUser.php Params(email, password, username, changePassword)
- http://localhost/api/deleteUser.php Params(email, password, deleteMe)

When a user is first created they must provide an email, password and username. The email and password is used for authentication to
allow a user to access or modify their tasks and user details.

## Available Task Calls
- http://localhost/api/task.php Params(email, password, name, type, priority)
- http://localhost/api/getUsersTasks.php Params(email, password, filterType, filterStatus, filterPriority, operator)
- http://localhost/api/updateTask.php Params(email, password, taskID, priority, status)
- http://localhost/api/deleteUser.php Params(email, password, id, name)

A users tasks can be filtered based on type, status and priority, or a combination of the three. Executing the calls in POSTMAN
or browser will provide messages about required parameters and how they should be used.

The SQL to create the tables can be found in the "tableCreationSQL.txt" file.

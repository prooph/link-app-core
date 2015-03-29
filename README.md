ProophLinkAppCoreModule
=======================
Application core for [prooph LINK](https://github.com/prooph/link)

# System Configuration

The main purpose of the module is to provide an API to create and maintain a processing configuration. The API is command based meaning other modules can use
the available [commands](https://github.com/prooph/link-app-core/tree/master/src/Command) to add or modify different parts of the application wide processing configuration.
Every change is also recorded with a related [event](https://github.com/prooph/link-app-core/tree/master/src/Event), so modules can react on configuration changes and
act accordingly.

## System Set Up

The system set up is also handled by this module. When starting a fresh installation of prooph LINK, the dashboard will only contain the app-core widget.
Via the widget the user can start a installation routine which creates a new `processing.local.php` config file in `<link root>/config/autoload`.
By default this file is ignored by GIT, because it contains dynamic configuration only valid for the current installation. 
However, when you want to develop a custom version of prooph LINK specific for your project, typically you want to track all changes. 
In this case you should adjust the .gitignore file in the config dir.
The set up routine also configures the default application and event store database. It is a SQLite filesystem DB located in `<link root>/data/sqlite`.
By default the application and event store share the same database. However, this can be changed manually via configuration. The event store manages the process stream
used by prooph/processing. It contains all processing events like started and finished processes and so on. The application DB is used by prooph LINK modules to store
additional information like a message log which is required to monitor the application.

## Ticker

Additionally to the configuration management the app-core module provides a tick mechanism. A [TickOccurred](https://github.com/prooph/link-app-core/blob/master/src/Event/TickOccurred.php) event
can be triggered from the outside world which is then published via the application event bus. Message dispatcher for example can listen on such a TickOccurred event and pull
pending messages from a worker queue.

### Javascript Ticker

One possibility to trigger a TickOccurred event is by activating the Javascirpt Ticker shipped with the app-core module. You can activate the ticker in the `System Configuration` menu
which you can access from the dashboard. The Javascript Ticker is implemented as a web worker. It starts its job on every page load and send a tick request every x seconds depending on
your settings. The web worker has the advantage that you can switch to another tab in your browser and the worker continues its task. As long as you don't close the application
the ticker will work. You will recognize a new item in the header navbar after activating the ticker. The icon color is changed to blue during a tick request. When you are waiting for a process to finish
you can look at the icon. Every time a tick is send the next step of the process should be executed. If something goes wrong the ticker will inform you with a notification. In such a case
you should also have a look at the [process monitor](https://github.com/prooph/link-monitor).

## Workflow Processor Message Queue

It is possible to activate a general message queue for all messages send by the workflow processor. For details about the processor please referrer to the [prooph/processing](https://github.com/prooph/processing) documentation.
The advantage of enabling the message queue is that you can make use of asynchronous worflow processing without the need to set up it for every process. Disadvantage is that you have to make sure that the amount of data per message
can be handled by the system so you have to process large data sets in chunks which makes your processes slower but also saver because you won't hit execution time or memory limits. 
If you want to get the full power out of prooph/processing it is recommended to not enable the general message queue but instead set up asynchronous message handling for every process individually.
How this can be done is described in the documentation of the [process-manager](https://github.com/prooph/link-process-manager) module.

# Support

- Ask any questions on [prooph-users](https://groups.google.com/forum/?hl=de#!forum/prooph) google group.
- File issues at [https://github.com/prooph/link/issues](https://github.com/prooph/link/issues).

# Contribution

You wanna help us? Great!
We appreciate any help, be it on implementation level, UI improvements, testing, donation or simply trying out the system and give us feedback.
Just leave us a note in our google group linked above and we can discuss further steps.

Thanks,
your prooph team

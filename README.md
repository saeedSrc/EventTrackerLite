# Project Name

Event Tracker



## Getting Started

### Prerequisites
- [PHP](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://www.mysql.com/downloads/)
- Web Server (e.g., [Apache](https://httpd.apache.org/download.cgi), [Nginx](https://nginx.org/en/download.html))

### Running with Docker

1. Install MySQL on your machine.
2. Create a new database named event_tracker for the project.
3. Set up a MySQL user with appropriate privileges for the project and put them into config/config.php.
4. enter your Mysql and run this command:
 
     ```bash
   source /path/to/your/project/migration.sql;
5. Clone the repository:
   ```bash
   git clone git@github.com:saeedSrc/EventTrackerLite.git

6. Navigate to the project directory:
    ```bash
   cd EventTrackerLite

7. Run Composer
   ```bash
   Composer install

5. Access the application

   simply go to you web server's path that serves this project.


## Usage

1. **Initialization:**
    - Open your web browser and navigate to [http://localhost:8090/](http://localhost:8090/).
    - If it's your first time visiting, the database will be initialized, and any unsaved records from the `booking.json` file will be transferred to the database.

2. **Adding New Records:**
    - To add new records, update the `booking.json` file with the desired information.
    - On subsequent visits to [http://localhost:8090/](http://localhost:8090/), any new records will be automatically saved to the database.

3. **Viewing All Records:**
    - Visit [http://localhost:8090/](http://localhost:8090/) to see all records currently stored in the database.

4. **Filtering Records:**
    - Customize your view by using the available filters:
        - **Employee Name:** Enter the employee's name to filter by.
        - **Event Name:** Enter the event name to filter by.
        - **Event Date:** Enter the event date to filter by.
    - Click the "Filter" button to apply the selected filters.
    - The table below will display the filtered results.

**Note:** Once a record is added, it won't be duplicated in the database. The system intelligently handles new additions and ensures data integrity.

Feel free to explore and interact with the application based on your preferences!



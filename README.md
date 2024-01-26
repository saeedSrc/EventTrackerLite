# Project Name

Event Tracker



## Getting Started

### Prerequisites
- [Docker](https://www.docker.com/)

### Running with Docker

1. Clone the repository:

   ```bash
   git clone git@github.com:saeedSrc/EventTrackerLite.git

2. Navigate to the project directory

   ```bash
   cd EventTrackerLite
   git checkout dockerize_project 

3. Build and run

   ```bash
   docker-compose up --build -d
4. Access the application

   simply go to the http://localhost:8090/


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



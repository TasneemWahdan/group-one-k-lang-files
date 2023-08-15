
## Group one-k-lang-files - Tamatem

</br>

## Overview

This code can be used to group files into sub-folders, each sub-folder to be named with its common language name.
The files provided, without grouping, are uploaded already into **resources/files directory**

I decided not to process all files at once, since the number of files is huge and might increase in the future, so I did the following:
   - Chunked the files and processed each chunk using app/Jobs/GroupFilesProcess.php <br />
   - The chunks are batched into bus and passed to queue <br />
</br>

## How to Use

To use this project follow these directions:

* Create a database with name "tamatem"

* In the root dirctory, make a copy of .env.example and name it .env, then make sure to modify these lines:
  ```
    DB_DATABASE= tamatem   
    DB_USERNAME= your DB username  
    DB_PASSWORD= your DB password  
    ```


* Open terminal on project's directory, then run the command:
  ```
   php artisan migrate
  ```
  
    This command will create tables from migration files into database<br />    
    <b>Note:</b> _You can check the tables jobs, job_batches and failed_jobs for details about the processed jobs with the queue_

* To group files into sub-folders, each sub-folder to be named with its common language name, run the command:
  ```
    php artisan app:group-files
  ```
* Run the command:<br />

```
    php artisan queue:work   
```

Now, you can see the jobs processed in the queue with their status on the terminal


Note:<br />
    You can upload any new language files into the resources/files directory, then run the command  <br />
    ```
    php artisan app:group-files 
    ```
    
The new files will be grouped as needed 

##### Please run following commands:
###### composer install
###### composer dump-autoload
##### To run server run command:
###### php -S localhost:8000

1. DealsController

    * Mail, database and validation services are declared in constructor.
    * index(): opens home view.
    * partners(): opens partners view.
    * create(): validates if input even exists, if it does, passes
    it to the validator, if validator says everything is okay, then appliation
    is submitted using database service and email is sent to the partner. 
    User is returned back to home.
    * offer(): validates if input even exists, if it does, passes 
    it to the validator, if validator says everything is okay, then deal status is
    changed and email is sent to the client.
    
1. Database

    * Implements DatabaseInterface
    * Connection to database is declared in controller.
    * getEmail(): gets email of user using id.
    * getDeals(): gets all deals joined with applications table.
    * offer(): changes deal type to offer.
    * submit(): creates application.
    * assign(): assigns partner to application and creates a deal.

1. MailService

    * Implements MailServiceInterface
    * send(): send email using recipient and path to email html file as arguments.

1. Validator

    * Implements ValidatorInterface
    * Connection to database is declared in controller.
    * email(): validates if email format is correct.
    * sum(): validates sum
    * id(): validates if deal id exists

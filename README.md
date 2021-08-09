## Fill data transfer object

- Requirements: **php8 or high**

Imagine this situation: 
```php
    public function actionCreatePost(Request $request): View 
    {
        // Step 1 validation request
        $this->validator->validateRequest($request);
        
        // We want to provide DTO class in our service
        $command = new Command();
        $command->title = $request->get('title');
        $command->description = $request->get('description');
        $command->pageTitle = $request->get('pageTitle');
        $command->pageDesc = $request->get('pageDesc');
        $command->authorId = $this->getUser()->id;
        // and can be more than 10 fields
        
        $this->service->savePost($command);
        
        // ...
    }
```

Do you want to decrease this code? This library can help you with them.

```php
    public function actionCreatePost(Request $request): View 
    {
        // Step 1 validation request
        $this->validator->validateRequest($request);
        
        $command = FillObjectService::fill(Command::class, array_merge([
            'authorId' => $this->getUser()->id   
        ], $request->request->all()));
        // That's cool
        
        $this->service->savePost($command);
        
        // ...
    }
```

What happened? 

- If I have **private properties**
- If I want to use **setters**
- If I have method **__construct** with any parameters
- And maybe I have **private setters** :) 

#### No problem!
You can use any DTO with private properties and/or private setters 
It will work any way.

This library uses \ReflectionClass to create DTO without __construct 
method and open access with private properties and methods.

### Install

As soon as possible.

### Tests

`docker-compose build`

`make test`


---
permalink: /docs/testing/handling-exceptions/
title: Handling Exceptions
---

Handling exceptions is an important part of software modeling. EventSauce
makes it easy to test failures. If our `AggregateRoot` guards an invariant,
we can create tests for that to ensure our business rule is respected.

For example, if there's a business rule that no one on a blacklist can
subscribe, we can create a test for this:

```php

<?php

namespace AmceCompany\SigningUp;

class SignUpRespectsBlackListTest extends SignUpProcessTestCase
{
    /**
     * @test
     */
    public function blacklist_is_respected()
    {
        $email = 'blacklisted@e-mail.com';

        $this->given(
            new SignUpWasInitiated()
        )->when(
            new SpecifyEmailForSignUp($email)
        )->expectToFail(
            SorryEmailAddressIsBlackListed::forEmail($email)
        );
    } 
}
``` 

## Recording events on failure

If you want to react to failures (exceptional cases) make sure you
persist the aggregate in a `finally` clause in your handler:

```php
protected function handle($command)
{
    $process = $this->repository->retrieve($command->processId());
    
    try {
        if ($command instanceof InitiateSignUpProcess) {
            $process->initiate($this->clock());           
        }
    } finally {
        $this->repository->persist($process);
    }
}
```

The `finally` clause will be triggered even though an exception is thrown. In
this case the events recorded prior to the exception are still recorded but
your exception still bubbles up, so you can handle it transparently.

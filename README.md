# Execute Command in loop

This is a PoC to show that when a command is executed a few times in a loop from
another command to send some mails, with different parameters, the successive
emails carry previous addresses (and attachments).

**Expected:**

- 1st mail sent: to = email-01@domain.tld
- 2nd mail sent: to = email-02@domain.tld
- ...
- 10th mail sent: to = email-10@domain.tld

**Actual issue:**

- 1st mail sent: to = email-01@domain.tld
- 2nd mail sent: to = email-01@domain.tld, email-02@domain.tld
- ...
- 10th mail sent: to = email-10@domain.tld, email-02@domain.tld, ... , email-10@domain.tld

## Run local smtp server

```shell
$ docker compose -f ./compose.override.yaml up -d
```
You can access the interface here: http://localhost:8025

## Run the command

```shell
$ bin/console my:loop:command
```
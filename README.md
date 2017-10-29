# TYPO3 Extension email2powermail

## Introduction

Convert Email-Addresses in TYPO3 Frontend to links to a powermail form. The form will be send to this email.
This will help you to hide email-addresses in frontend from spiders.

## Screens

First of all define some email-addresses and add some names to it:
<img src="https://box.everhelper.me/attachment/595878/84725fb7-0b3e-4c40-b52e-29d7620777bb/262407-iWRZKXYzDd9pS5gh/screen.png" />

Editors can add email addresses anywhere in the frontend:
<img src="https://box.everhelper.me/attachment/595867/84725fb7-0b3e-4c40-b52e-29d7620777bb/262407-L1fE5LVYpJFYYmDg/screen.png" />

But emails will not be shown in frontend:
<img src="https://box.everhelper.me/attachment/595868/84725fb7-0b3e-4c40-b52e-29d7620777bb/262407-GBBva1Qs3n0sJVsm/screen.png" />

Instead they will parsed into links to a powermail form:
<img src="https://box.everhelper.me/attachment/595869/84725fb7-0b3e-4c40-b52e-29d7620777bb/262407-5vJ1ulSnfJu5Mx3W/screen.png" />

After clicking a link, a powermail form will be shown:
<img src="https://box.everhelper.me/attachment/595870/84725fb7-0b3e-4c40-b52e-29d7620777bb/262407-BKYtdeLxMs6Twkhq/screen.png" />

Example if form was sent:
<img src="https://box.everhelper.me/attachment/595871/84725fb7-0b3e-4c40-b52e-29d7620777bb/262407-NlwY3RJGnnBU4XDZ/screen.png" />

## Installation

* Install powermail 3.8.0 (or minimum 3.0.0) first
* Install this extension
* Take care that static templates (powermail and email2powermail are included) - Important: powermail must be included before email2powermail!
* Add a powermail form to a page and remember the PID (e.g. 123)
* Add this pid to constants: plugin.tx_email2powermail.settings.pid=123
* Add some email-records to a sysfolder (all this emails will be encoded in frontend)
* Have fun!

## Dependencies

* Powermail 3.0.0 or higher (best work with 3.8 or higher)
* TYPO3 7.6 or higher
* PHP 5.5 or higher

## Changelog

| Version    | Date       | Description                                          |
| ---------- |:----------:| ----------------------------------------------------:|
| 2.0.0      | 2017-10-29 | Update for powermail 4.x                             |
| 1.1.1      | 2017-05-20 | TCA update for TYPO3 8.7                             |
| 1.1.0      | 2017-03-17 | Add simple mode to convert all email addresses       |
| 1.0.1      | 2016-10-05 | Prevent function if extension is turned off          |
| 1.0.0      | 2016-10-03 | Complete refactored version of email2powermail       |

## Best practice

### 1) Add a label field to the form

If you want to add a label field in the form, you can add a new field of type TypoScript and add the path **lib.email2powermail.decode.introductionText**
With this a field will be shown at first if powermail will be called from a link.

<img src="https://box.everhelper.me/attachment/595880/84725fb7-0b3e-4c40-b52e-29d7620777bb/262407-hhA2gwdy361MJ8og/screen.png" />

Of course you can also use this TypoScript in your setup if you need this.

### 2) Use a marker after the form is submitted to show where the mail goes

You can use markers like {email2powermail_name} or {email2powermail_email} in the RTE of powermail:

<img src="https://box.everhelper.me/attachment/595881/84725fb7-0b3e-4c40-b52e-29d7620777bb/262407-iHWFfwAInNcHicB8/screen.png" />

### 3) Use another table for encoding (e.g. fe_users or be_users)

See TypoScript file EXT:email2powermail/Configuration/TypoScript/setup.txt - there is a mapping configuration. Per default
tx_email2powermail_domain_model_email will be used, but you can also use another table - see following example.
Use fe_users which are located in pages 1 or 237. Use field *email* for email and use field *first_name* for name:

```
config.tx_extbase {
	persistence {
		classes {
			In2code\Email2powermail\Domain\Model\Email {
				# Example how to use fe_users instead of tx_email2powermail_domain_model_email
				mapping {
					tableName = fe_users
					columns {
						uid.mapOnProperty = identifier
						email.mapOnProperty = email
						first_name.mapOnProperty = name
					}
					in {
						pid = 1,237
					}
				}
			}
		}
	}
}
```

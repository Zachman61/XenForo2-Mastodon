# Mastodon Integration for XenForo 2
Adds a connected account provider for XenForo 2 that allows OAuth 2 integration with an Mastodon instance.
## Installing
 - Install the add-on by extracting the contents of the upload folder to the root of your XenForo 2 installation.
 - Visit ACP and click install on `Mastodon integration`
 - Then configure the add-on by following the steps below.
## Setting up your Mastodon app
For this example, I'll be using [mastodon.xyz](http://mastodon.xyz/), but any proper Mastodon instance should follow the exact same setup other than the URL.
 - Create your application by visiting the developer settings area. Example: https://mastodon.xyz/settings/applications.
    1. Name your application whatever you wish, a good idea is probably your board's name
    2. Add your board's URL to the _Application Website_ field
    3. Remove the placeholder text from the _Redirect URI_ field
    4. Add `yoursite.com/connected_account.php` to the field, replacing `yoursite.com` with your board's URL.
    5. Uncheck all scopes but `read` as they are not used by the integration at this time.

## Configuring the add-on
The Mastodon's application settings need to placed into the Mastodon provider in the connected accounts section of your ACP.
The instance URL that you use needs to be placed in Options -> Mastodon options -> Mastodon instance URL.

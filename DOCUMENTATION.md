# Third Party Docs
Manage third party scripts and pixels (tags); like GTM but not.

- [Installing](#Installing)
- [Usage](#Usage)
- [Tags](#Tags)
- [Parameters](#Parameters)
- [Settings](#Settings)

---

## Installing
Unzip the package into ``/site/addons/ThirdParty``

*Optional:* Third Party comes with a fieldset partial you can use on any of your content fieldsets. If you would like to use it, move the ``/fieldsets/third_party.yaml`` file into ``/site/settings/fieldsets`` and utilize it like any other partial.

## Usage
Place the whichever tags you want to use in the layout file of your site.

*Optional:* If you're using the fieldset, you'll need to add that to your layout/templates as well.

## Tags
- [third_party](#Third_Party)
- [third_party:head](#Third_Party:Head)
- [third_party:body](#Third_Party:Body)

### Third_Party
The default tag, you must supply a ``type`` with this tag and may optionally supply a ``position`` (specifically for body tags).

```
{{ third_party type="head" }}
```

### Third_Party:Head
The same as the default but allows you to skip the type parameter.

```
{{ third_party:head }}
```

### Third_Party:Body
The body tag allows you to specify a ``position`` for placing tags in the top or bottom of the html body. The default is bottom so you can omit the position parameter if you're only adding tags to the end.

Top:
```
<!-- Place directly after the <body> tag -->
{{ third_party:body position="top" }}
```

Bottom:
```
<!-- Place directly before the </body> tag -->
{{ third_party:body }}
```

## Parameters
There's very few parameters to play with but for completeness:

``type``

The type of tags to add. Available options are: **head** and **body**.

``position``

Specifies which body tags to pull. Available options are: **top** and **bottom**.

## Settings
You'll likely want to utilize the settings menu for managing scripts/pixel tags. The addon was created with a more visually organized and usable CP than editing through YAML. To access go to Addons -> ThirdParty -> Settings.

### Global
Global scripts/pixels are applied to every route across the site. This is a good place to put things like Google Analytics.

### Routes
Route scripts/pixels allow you to specify route patterns to match for tags. Currently, it's a pretty simple formula:
- ``/blog``: Would match *only* the /blog page. This is useful if you're not using the fieldset partial.
- ``/blog/*``: Would match *children* of the blog page but not the blog root itself.
- ``/blog*``: Would match *both* the root blog page and it's children.

Skypress
=========

Skypress is a PHP framework for WordPress CMS wants to make a response to several issues that revolve around WordPress:

- The Object Oriented Programming
- Maintainability projects
- Versioning
- Code portability

Currently, the documentation on the site is only in French. The English translation will gradually

## Get started

### Create theme

```php
//wp-content/themes/name_theme/functions.php

use Skypress\KernelSkypress;

class MyTheme {

    protected $myTheme = null;

    public function execute(){


        $this->myTheme = KernelSkypress::getInstance('theme');
        $this->myTheme->execute();
    }


}
$theme = new MyTheme();
$theme->execute();
```

### Create CustomPostType and Taxonomies with XML file

```xml
<!-- wp-content/themes/name_theme/src/app/config/parameters.xml  -->
<container>
  <parameters>
        <parameter key="cpt.slug.movie">movies</parameter>
  </parameters>
  <services>
    <service name="Taxonomy">
      <taxonomy slug="genre" post-types="movies">
        <labels>
          <name>Genres</name>
          <singular_name>Genre</singular_name>
          <search_items>Search genre</search_items>
          <popular_items>Popular genres</popular_items>
          <all_items>All genres</all_items>
          <edit_item>Edit a genre</edit_item>
          <update_item>Edit a genre</update_item>
          <add_new_item>Add a genre</add_new_item>
          <new_item_name>Add a new genre</new_item_name>
          <add_or_remove_items>Add or delete a genre</add_or_remove_items>
          <not_found>No genre</not_found>
          <menu_name>Genres</menu_name>
        </labels>
      </taxonomy>
    </service>

    <service name="CustomPostType">
      <custom-post-type slug="movies">
        <labels>
          <name>Movie</name>
          <singular_name>Movie</singular_name>
          <name_admin_bar>Movies</name_admin_bar>
          <add_new>Add a movie</add_new>
          <add_new_item>Add a new movie</add_new_item>
          <all_items>All movies</all_items>
          <new_item>Add a movie</new_item>
          <edit_item>Edit a movie</edit_item>
          <view_item>View a movie</view_item>
          <search_items>Search a movie</search_items>
          <parent_item_colon>Movie parent</parent_item_colon>
          <not_found>No movies found</not_found>
          <not_found_in_trash>No movies found in the trash</not_found_in_trash>
          <menu_name>Movies</menu_name>
        </labels>
        <supports type="collection">
          <argument>title</argument>
          <argument>editor</argument>
          <argument>author</argument>
          <argument>thumbnail</argument>
          <argument>excerpt</argument>
          <argument>comments</argument>
        </supports>
      </custom-post-type>
    </service>

  </services>
</container>
```

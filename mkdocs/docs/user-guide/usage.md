Usage
=====

The plugin should be activated for the blog (see main [setting page](/user-guide/settings) of this plugin) before using it.


Using YASH in content
---------------------

In order to specify codes to be rendered by YASH you have to use the following syntax:

In **Wiki** mode:

```
///yash language_code
...
///
```

In **HTML** (source) or **Markdown** modes:

```html
<pre class="brush: language_code">
...
</pre>
```

Replacing ```language_code``` by one of the [following syntaxes](#available-syntaxes)

Exemple with this Javascript code:

```
///yash js
function findSequence(goal) {
  function find(start, history) {
    if (start == goal)
      return history;
    else if (start > goal)
      return null;
    else
      return find(start + 5, "(" + history + " + 5)") ||
             find(start * 3, "(" + history + " * 3)");
  }
  return find(1, "1");
}
///
```

!!! tip
	A toolbar button is available for dcLegacyEditor (wiki/markown and wysiwyg in source mode) to select syntax:  

	![dcLegacyEditor button](../img/yash-toolbar.jpg)


Available syntaxes
------------------

| Language code | Syntaxe             |
| ------------- | ------------------- |
| plain         | Plain Text          |
| applescript   | AppleScript         |
| as3           | ActionScript3       |
| bash          | Bash/shell          |
| cf            | ColdFusion          |
| csharp        | C#                  |
| cpp           | C/C++               |
| css           | CSS                 |
| delphi        | Delphi              |
| diff          | Diff/Patch          |
| erl           | Erlang              |
| groovy        | Groovy              |
| haxe          | Haxe                |
| js            | Javascript/JSON     |
| java          | Java                |
| jfx           | JavaFX              |
| pl            | Perl                |
| php           | PHP                 |
| ps            | PowerShell          |
| python        | Python              |
| ruby          | Ruby                |
| sass          | SASS                |
| scala         | Scala               |
| sql           | SQL                 |
| tap           | Tap                 |
| ts            | TypeScript          |
| vb            | Visual Basic        |
| xml           | XML/XSLT/XHTML/HTML |
| yaml          | Yaml                |

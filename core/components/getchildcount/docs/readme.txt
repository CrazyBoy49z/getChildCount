--------------------
getChildCount
--------------------
Author: igor Hrebenozhko <inogdasms@gmail.com>
--------------------

number of child resource documents in MODX Revo.
Use it as output filter: 
[[!getChildCount? 
    &parent=`id - list of parents` 
    &depth=`Search depth of child resources from parent in the Resource Tree` 
    &template=`template to filter results` 
    &*=`you can select all fields 'site_content' to filter the result` 
    &toPlaceholder=`If not empty, the snippet will save its output to a placeholder with the same name, instead of returning the generated menu.`]]


--------------------
Feel free to suggest ideas/improvements/bugs on GitHub:
http://github.com/hrebenozhko/getChildCount/issues
--------------------
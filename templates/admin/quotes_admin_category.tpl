<{* Rich-text in admin list cells: keep inline highlights/backgrounds behind the text. The
   "default" admin theme reset forces inline elements to vertical-align:top, which lifts a
   highlighted span's background above the line — reset it to baseline for content cells. *}>
<style>.outer td span,.outer td strong,.outer td em,.outer td b,.outer td i,.outer td a,.outer td mark,.outer td font,.outer td sub,.outer td sup{vertical-align:baseline;}</style>
<{if $categoryRows > 0}>
    <div class="outer">
        <form name="select" action="category.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('category_id[]');} else if (isOneChecked('category_id[]')) {return true;} else {alert('<{$smarty.const._AM_QUOTES_SELECTED_ERROR}>'); return false;}">
            <input type="hidden" name="confirm" value="1">
            <div class="floatleft">
                <select name="op">
                    <option value=""><{$smarty.const._AM_QUOTES_SELECT}></option>
                    <option value="delete"><{$smarty.const._AM_QUOTES_SELECTED_DELETE}></option>
                </select>
                <input id="submitUp" class="formButton" type="submit" name="submitselect" value="<{$smarty.const._SUBMIT}>" title="<{$smarty.const._SUBMIT}>">
            </div>
            <div class="floatcenter0">
                <div id="pagenav"><{$pagenav|default:false}></div>
            </div>


            <table class="outer" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorid}></th>
                    <th class="left"><{$selectorpid}></th>
                    <th class="left"><{$selectortitle}></th>
                    <th class="left"><{$selectordescription}></th>
                    <th class="left"><{$selectorimage}></th>
                    <th class="center"><{$selectorweight}></th>
                    <th class="center"><{$selectorcolor}></th>
                    <th class="center"><{$selectoronline}></th>

                    <th class="center width5"><{$smarty.const._AM_QUOTES_FORM_ACTION}></th>
                </tr>
                <{foreach item=categoryArray from=$categoryArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="category_id[]" title="category_id[]" value="<{$categoryArray.id}>"></td>
                        <td class='left'><{$categoryArray.id}></td>
                        <td class='left'><{$categoryArray.pid}></td>
                        <td class='left'><{$categoryArray.title}></td>
                        <td class='left'><{$categoryArray.description}></td>
                        <td class='left'><{$categoryArray.image}></td>
                        <td class='center'><{$categoryArray.weight}></td>
                        <td class='center'><{$categoryArray.color}></td>
                        <td class='center'><{$categoryArray.online}></td>


                        <td class="center width5"><{$categoryArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
        </form>
    </div>
    <br>
    <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorid}></th>
                    <th class="left"><{$selectorpid}></th>
                    <th class="left"><{$selectortitle}></th>
                    <th class="left"><{$selectordescription}></th>
                    <th class="left"><{$selectorimage}></th>
                    <th class="center"><{$selectorweight}></th>
                    <th class="center"><{$selectorcolor}></th>
                    <th class="center"><{$selectoronline}></th>

                    <th class="center width5"><{$smarty.const._AM_QUOTES_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $category</td>
                </tr>
            </table>
    <br>
    <br>
<{/if}>

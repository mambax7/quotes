<{if $authorRows > 0}>
    <div class="outer">
        <form name="select" action="author.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('authorId[]');} else if (isOneChecked('authorId[]')) {return true;} else {alert('<{$smarty.const.AM_QUOTES_SELECTED_ERROR}>'); return false;}">
            <input type="hidden" name="confirm" value="1">
            <div class="floatleft">
                <select name="op">
                    <option value=""><{$smarty.const.AM_QUOTES_SELECT}></option>
                    <option value="delete"><{$smarty.const.AM_QUOTES_SELECTED_DELETE}></option>
                </select>
                <input id="submitUp" class="formButton" type="submit" name="submitselect" value="<{$smarty.const._SUBMIT}>" title="<{$smarty.const._SUBMIT}>">
            </div>
            <div class="floatcenter0">
                <div id="pagenav"><{$pagenav|default:false}></div>
            </div>


            <table class="$author" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorid}></th>
                    <th class="left"><{$selectorname}></th>
                    <th class="center"><{$selectorcountry}></th>
                    <th class="left"><{$selectorbio}></th>
                    <th class="left"><{$selectorphoto}></th>
                    <th class="left"><{$selectorcreated}></th>
                    <th class="left"><{$selectorupdated}></th>

                    <th class="center width5"><{$smarty.const.AM_QUOTES_FORM_ACTION}></th>
                </tr>
                <{foreach item=authorArray from=$authorArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="author_id[]" title="author_id[]" id="author_id[]" value="<{$authorArray.author_id|default:false}>"></td>
                        <td class='left'><{$authorArray.id}></td>
                        <td class='left'><{$authorArray.name}></td>
                        <td class='center'><{$authorArray.country}></td>
                        <td class='left'><{$authorArray.bio}></td>
                        <td class='left'><{$authorArray.photo}></td>
                        <td class='left'><{$authorArray.created}></td>
                        <td class='left'><{$authorArray.updated}></td>


                        <td class="center width5"><{$authorArray.edit_delete}></td>
                    </tr>
                <{/foreach}>
            </table>
            <br>
            <br>
            <{else}>
            <table width="100%" cellspacing="1" class="outer">
                <tr>

                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorid}></th>
                    <th class="left"><{$selectorname}></th>
                    <th class="center"><{$selectorcountry}></th>
                    <th class="left"><{$selectorbio}></th>
                    <th class="left"><{$selectorphoto}></th>
                    <th class="left"><{$selectorcreated}></th>
                    <th class="left"><{$selectorupdated}></th>

                    <th class="center width5"><{$smarty.const.AM_QUOTES_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $author</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>

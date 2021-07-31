<{if $quoteRows > 0}>
    <div class="outer">
        <form name="select" action="quote.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('quoteId[]');} else if (isOneChecked('quoteId[]')) {return true;} else {alert('<{$smarty.const.AM_QUOTES_SELECTED_ERROR}>'); return false;}">
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


            <table class="$quote" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th align="center" width="5%"><input name="allbox" title="allbox" id="allbox" onclick="xoopsCheckAll('select', 'allbox');" type="checkbox" title="Check All" value="Check All"></th>
                    <th class="left"><{$selectorid}></th>
                    <th class="left"><{$selectorcid}></th>
                    <th class="left"><{$selectorauthor_id}></th>
                    <th class="left"><{$selectorquote}></th>
                    <th class="left"><{$selectoronline}></th>
                    <th class="left"><{$selectorcreated}></th>
                    <th class="left"><{$selectorupdated}></th>

                    <th class="center width5"><{$smarty.const.AM_QUOTES_FORM_ACTION}></th>
                </tr>
                <{foreach item=quoteArray from=$quoteArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="quote_id[]" title="quote_id[]" id="quote_id[]" value="<{$quoteArray.quote_id|default:false}>"></td>
                        <td class='left'><{$quoteArray.id}></td>
                        <td class='left'><{$quoteArray.cid}></td>
                        <td class='left'><{$quoteArray.author_id}></td>
                        <td class='left'><{$quoteArray.quote}></td>
                        <td class='left'><{$quoteArray.online}></td>
                        <td class='left'><{$quoteArray.created}></td>
                        <td class='left'><{$quoteArray.updated}></td>


                        <td class="center width5"><{$quoteArray.edit_delete}></td>
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
                    <th class="left"><{$selectorcid}></th>
                    <th class="left"><{$selectorauthor_id}></th>
                    <th class="left"><{$selectorquote}></th>
                    <th class="left"><{$selectoronline}></th>
                    <th class="left"><{$selectorcreated}></th>
                    <th class="left"><{$selectorupdated}></th>

                    <th class="center width5"><{$smarty.const.AM_QUOTES_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $quote</td>
                </tr>
            </table>
    </div>
    <br>
    <br>
<{/if}>

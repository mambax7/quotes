<{* Rich-text in admin list cells: keep inline highlights/backgrounds behind the text. The
   "default" admin theme reset forces inline elements to vertical-align:top, which lifts a
   highlighted span's background above the line — reset it to baseline for content cells. *}>
<style>.outer td span,.outer td strong,.outer td em,.outer td b,.outer td i,.outer td a,.outer td mark,.outer td font,.outer td sub,.outer td sup{vertical-align:baseline;}</style>
<{if $quoteRows > 0}>
    <div class="outer">
        <form name="select" action="quote.php?op=" method="POST"
              onsubmit="if(window.document.select.op.value =='') {return false;} else if (window.document.select.op.value =='delete') {return deleteSubmitValid('quote_id[]');} else if (isOneChecked('quote_id[]')) {return true;} else {alert('<{$smarty.const._AM_QUOTES_SELECTED_ERROR}>'); return false;}">
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
                    <th class="left"><{$selectorcid}></th>
                    <th class="left"><{$selectorauthor_id}></th>
                    <th class="left"><{$selectorquote}></th>
                    <th class="left"><{$selectoronline}></th>
                    <th class="left"><{$selectorsubmitter}></th>
                    <th class="left"><{$selectorcreated}></th>
                    <th class="left"><{$selectorupdated}></th>

                    <th class="center width5"><{$smarty.const._AM_QUOTES_FORM_ACTION}></th>
                </tr>
                <{foreach item=quoteArray from=$quoteArrays}>
                    <tr class="<{cycle values="odd,even"}>">

                        <td align="center" style="vertical-align:middle;"><input type="checkbox" name="quote_id[]" title="quote_id[]" value="<{$quoteArray.id}>"></td>
                        <td class='left'><{$quoteArray.id}></td>
                        <td class='left'><{$quoteArray.cid}></td>
                        <td class='left'><{$quoteArray.author_id}></td>
                        <td class='left'><{$quoteArray.quote}></td>
                        <td class='left'><{$quoteArray.online}></td>
                        <td class='left'><{$quoteArray.submitter}></td>
                        <td class='left'><{$quoteArray.created}></td>
                        <td class='left'><{$quoteArray.updated}></td>


                        <td class="center width5"><{$quoteArray.edit_delete}></td>
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
                    <th class="left"><{$selectorcid}></th>
                    <th class="left"><{$selectorauthor_id}></th>
                    <th class="left"><{$selectorquote}></th>
                    <th class="left"><{$selectoronline}></th>
                    <th class="left"><{$selectorsubmitter}></th>
                    <th class="left"><{$selectorcreated}></th>
                    <th class="left"><{$selectorupdated}></th>

                    <th class="center width5"><{$smarty.const._AM_QUOTES_FORM_ACTION}></th>
                </tr>
                <tr>
                    <td class="errorMsg" colspan="11">There are no $quote</td>
                </tr>
            </table>
    <br>
    <br>
<{/if}>

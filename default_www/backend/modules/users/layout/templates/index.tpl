{include:file='{$BACKEND_CORE_PATH}/layout/templates/header.tpl'}
{include:file='{$BACKEND_CORE_PATH}/layout/templates/sidebar.tpl'}
	<td id="contentHolder">
		<div class="inner">
			<div class="pageTitle">
				<h2>{$lblUsers|ucfirst}</h2>
				<div class="buttonHolderRight">
					<a class="button icon iconAdd" href="{$var|geturl:'add'}"><span><span><span>{$lblAdd|ucfirst}</span></span></span></a>
				</div>
			</div>
			<div class="datagridHolder">
				{option:datagrid}{$datagrid}{/option:datagrid}
				{option:!datagrid}{$msgNoItems}{/option:!datagrid}
			</div>
		</div>
	</tr>
</table>
{include:file='{$BACKEND_CORE_PATH}/layout/templates/footer.tpl'}

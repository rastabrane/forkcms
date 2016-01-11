{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>{$lblAdd|ucfirst}</h2>
  </div>
</div>
{form:add}
  <div class="row fork-module-content">
    <div class="col-md-12">
      <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active">
            <a href="#tabProfile" aria-controls="profile" role="tab" data-toggle="tab">{$lblProfile|ucfirst}</a>
          </li>
          <li role="presentation">
            <a href="#tabPermissions" aria-controls="permission" role="tab" data-toggle="tab">{$lblPermissions|ucfirst}</a>
          </li>
        </ul>
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="tabProfile">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="email">
                    {$lblEmail|ucfirst}&nbsp;
                    <abbr data-toggle="tooltip" title="{$lblRequiredField|ucfirst}">*</abbr>
                  </label>
                  {$txtEmail} {$txtEmailError}
                </div>
                <div class="form-group">
                  <label for="password">
                    {$lblPassword|ucfirst}&nbsp;
                    <abbr data-toggle="tooltip" title="{$lblRequiredField|ucfirst}">*</abbr>
                  </label>
                  <table id="passwordStrengthMeter" class="passwordStrength" data-id="password">
                    <tr>
                      <td class="strength" id="passwordStrength">
                        <p class="strength none">
                          <span class="label label-default">None</span>
                        </p>
                        <p class="strength weak">
                          <span class="label label-danger">Weak</span>
                        </p>
                        <p class="strength average">
                          <span class="label label-warning">Average</span>
                        </p>
                        <p class="strength strong">
                          <span class="label label-success">Strong</span>
                        </p>
                      </td>
                      <td>
                        <p class="help-block">&nbsp;{$msgHelpStrongPassword}</p>
                      </td>
                    </tr>
                  </table>
                  <div class="form-group form-inline">
                    <div class="form-group">
                      {$txtPassword} {$txtPasswordError}
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="confirmPassword">
                    {$lblConfirmPassword|ucfirst}
                    <abbr data-toggle="tooltip" title="{$lblRequiredField|ucfirst}">*</abbr>
                  </label>
                  <div class="form-group form-inline">
                    <div class="form-group">
                      {$txtConfirmPassword} {$txtConfirmPasswordError}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h3>{$lblPersonalInformation|ucfirst}</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name">
                    {$lblName|ucfirst}
                    <abbr data-toggle="tooltip" title="{$lblRequiredField|ucfirst}">*</abbr>
                  </label>
                  {$txtName} {$txtNameError}
                </div>
                <div class="form-group">
                  <label for="surname">
                    {$lblSurname|ucfirst}
                    <abbr data-toggle="tooltip" title="{$lblRequiredField|ucfirst}">*</abbr>
                  </label>
                  {$txtSurname} {$txtSurnameError}
                </div>
                <div class="form-group">
                  <label for="nickname">
                    {$lblNickname|ucfirst}
                    <abbr data-toggle="tooltip" title="{$lblRequiredField|ucfirst}">*</abbr>
                  </label>
                  <p class="help-block">{$msgHelpNickname}</p>
                  {$txtNickname} {$txtNicknameError}
                </div>
                <div class="form-group">
                  <label for="avatar">{$lblAvatar|ucfirst}</label>
                  <p class="help-block">{$msgHelpAvatar}</p>
                  {$fileAvatar} {$fileAvatarError}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h3>{$lblInterfacePreferences|ucfirst}</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="interfaceLanguage">{$lblLanguage|ucfirst}</label>
                  {$ddmInterfaceLanguage} {$ddmInterfaceLanguageError}
                </div>
                <div class="form-group">
                  <label for="dateFormat">{$lblDateFormat|ucfirst}</label>
                  {$ddmDateFormat} {$ddmDateFormatError}
                </div>
                <div class="form-group">
                  <label for="timeFormat">{$lblTimeFormat|ucfirst}</label>
                  {$ddmTimeFormat} {$ddmTimeFormatError}
                </div>
                <div class="form-group">
                  <label for="numberFormat">{$lblNumberFormat|ucfirst}</label>
                  {$ddmNumberFormat} {$ddmNumberFormatError}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h3>{$lblCSV|ucfirst}</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="csvSplitCharacter">{$lblSplitCharacter|ucfirst}</label>
                  {$ddmCsvSplitCharacter} {$ddmCsvSplitCharacterError}
                </div>
                <div class="form-group">
                  <label for="csvLineEnding">{$lblLineEnding|ucfirst}</label>
                  {$ddmCsvLineEnding} {$ddmCsvLineEndingError}
                </div>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="tabPermissions">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <ul class="list-unstyled">
                    <li class="checkbox">
                      <label for="active">{$chkActive} {$msgHelpActive}</label> {$chkActiveError}
                    </li>
                    <li class="checkbox">
                      <label for="apiAccess">{$chkApiAccess} {$msgHelpAPIAccess}</label> {$chkApiAccessError}
                    </li>
                  </ul>
                </div>
                <div class="form-group">
                  <p>{$lblGroups|ucfirst}</p>
                  <ul id="groupList" class="list-unstyled">
                    {iteration:groups}
                    <li class="checkbox">
                      <label for="{$groups.id}">{$groups.chkGroups} {$groups.label}</label>
                    </li>
                    {/iteration:groups}
                  </ul>
                  {$chkGroupsError}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row fork-page-actions">
    <div class="col-md-12">
      <div class="btn-toolbar">
        <div class="btn-group pull-right" role="group">
          <button id="addButton" type="submit" name="add" class="btn btn-primary">
            <span class="fa fa-plus"></span>&nbsp;
            {$lblAdd|ucfirst}
          </button>
        </div>
      </div>
    </div>
  </div>
{/form:add}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}

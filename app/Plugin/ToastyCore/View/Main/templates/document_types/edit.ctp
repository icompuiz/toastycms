<form class="container cmsForm" name="cmsForm">
	<div class="flash-messages">
		<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">{{alert.message}}</alert>
	</div>
	<div class="form-group" title="The name for this type">
		<input type="text" class="form-control text-input" id="documentTypeName" name="documentTypeName" placeholder="Enter Type Name" ng-model="documentType.DocumentType.name">
		<label for="documentTypeName">Name</label>
	</div>
	
	<tabset>
		<tab heading="Type">
			<label for="documentMeta">Meta Data</label>
			<div class="form-group document-meta" title="Document Meta Data">
				<p>id: {{documentType.DocumentType.id}}</p>
				<p ng-show="documentType.parent.DocumentType">parent: {{documentType.parent.DocumentType.name}}</p>
				<p>created: {{documentType.DocumentType.created}}</p>
				<p>last modified: {{documentType.DocumentType.modified}}</p>
			</div>
		</tab>
		<tab heading="Properties">
			<div class="pull-left">
				<div class="btn-group">
					<button class="btn btn-primary" title="Add a property" ng-click="addProperty()">
						<span class="glyphicon glyphicon-plus control-icon"></span>
						<span class="control-text">
							Define a new property
						</span>
					</button>
				</div>
			</div>
			<div class="clearfix"></div>
			<hr>
			<accordion close-others="oneAtATime">
				<accordion-group ng-repeat="property in documentType.DocumentTypeProperty" is-open="isopen">
				<accordion-heading>
				<div><span class="pull-left glyphicon glyphicon-edit"></span>&nbsp;&nbsp;{{property.name}} <span class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': isopen, 'glyphicon-chevron-right': !isopen}"></span></div>
			</accordion-heading>
			<div class="pull-right">
				<div class="btn-group">
					<button class="btn btn-danger" title="Add a property" ng-click="removeProperty($index)">
						<span class="glyphicon glyphicon-remove control-icon"></span>
						<span class="control-text">
							Remove Property
						</span>
					</button>
				</div>
			</div>
			<div class="clearfix"></div>
			<hr>
			<div class="form-group" title="The name for this property">
				<input type="text" class="form-control text-input" name="documentTypePropertyName_{{property.name | alphanumeric }}" id="documentTypePropertyName_{{property.name | alphanumeric }}"  class="documentTypePropertyName" placeholder="Enter Property Name" ng-model="property.name">
				<label for="documentTypePropertyName_{{property.name | alphanumeric }}">Name</label>
			</div>
			<div class="form-group">
				<select class="form-control" ng-model="property.input_format_id" name="documentTypePropertyInputFormat_{{property.name | alphanumeric}}">
					<option   ng-repeat="format in vm.properties.inputFormats" value="{{format.id}}" ng-selected="{{property.input_format_id == format.id}}">
						{{format.name}}
					</option>
				</select>
				<hr class="propertyInputFormatSep">
				<label for="documentTypePropertyInputFormat_{{property.name | alphanumeric}}">Input format</label>
			</div>
			<div class="form-group">
				<select class="form-control" ng-model="property.output_format_id" name="documentTypePropertyOutFormat_{{property.name | alphanumeric}}">
					<option   ng-repeat="format in vm.properties.outputFormats" value="{{format.id}}" ng-selected="{{property.output_format_id == format.id}}">
						{{format.name}}
					</option>
				</select>
				<hr class="propertyInputFormatSep">
				<label for="documentTypePropertyOutputFormat_{{property.name | alphanumeric}}">Output format</label>
			</div>
		</accordion-group>
	</accordion>
</tab>
<tab heading="Parent Type">
	<div class="btn-group">
		<a class="btn btn-primary" title="Change parent type">
			<span class="glyphicon glyphicon-edit control-icon"></span>
			<span class="control-text">
				Set Parent Type
			</span>
		</a>
	</div>
	<hr> 
	<div ng-show="documentType.parent.DocumentType">
		<div class="form-group" title="The parent type">
			<a name="documentParentName" id="documentParentName" class="form-control text-label" href="#/document_types/edit/{{documentType.parent.DocumentType.id}}">{{documentType.parent.DocumentType.name}}</a>
			<label for="documentParentName">Parent Name</label>
		</div>
		<label for="documentMeta">Parent Meta Data</label>
		<div class="form-group document-meta" title="Document Meta Data">
			<p>id: {{documentType.parent.DocumentType.id}}</p>
			<p>created: {{documentType.parent.DocumentType.created}}</p>
			<p>last modified: {{documentType.parent.DocumentType.modified}}</p>
		</div>
	</div>
</tab>
<tab heading="Children">
	<div class="tab-controls">
		<div class="pull-left">
			<div class="btn-group">
				<a class="btn btn-primary" title="Add a child document" href="#/document_types/add/{{documentType.DocumentType.id}}">
					<span class="glyphicon glyphicon-plus control-icon"></span>
					<span class="control-text">
						Add Child Type
					</span>

				</a>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<hr>
	<div class="tgrid">
		<div class="grid-item " ng-repeat="cdocumentType in documentType.children">
			<a href="#/document_types/edit/{{cdocumentType.DocumentType.id}}">
				<span class="item-icon glyphicon glyphicon-file"></span>
				<div class="caption">
					{{cdocumentType.DocumentType.name}}
				</div>
			</a>
		</div>
	</div>
	<div class="clearfix"></div>
</tab>
</tabset>

<nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse main-nav">
	<div class="page-controls">
		<div class="pull-right">

			<div class="btn-group">
				<button type="button" class="btn btn-primary" ng-click="saveType()">
					<span class="glyphicon glyphicon-save control-icon"></span>
					<span class="control-text">
						Save
					</span>

				</button>
				<button type="button" class="btn btn-warning" ng-click="cancelChanges()">
					<span class="glyphicon glyphicon-floppy-remove control-icon"></span>

					<span class="control-text">
						Cancel
					</span>
				</button>
				<button type="button" class="btn btn-danger" ng-click="deleteType()">
					<span class="glyphicon glyphicon-trash control-icon"></span>

					<span class="control-text">
						Delete
					</span>
				</button>
			</div>
		</div>
	</div>
</nav>
<input type="hidden" name="documentProperties" id="documentProperties" ng-model="documentType.DocumentTypeProperties">
<input type="hidden" name="documentParent" id="documentParent" ng-model="documentType.parent.Document">
</form>
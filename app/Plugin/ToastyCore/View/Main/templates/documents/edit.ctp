<form class="container cmsForm" name="cmsForm">
	<div class="flash-messages">
		<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">{{alert.message}}</alert>
	</div>
	<div class="form-group" title="The name for this document">
		<input type="text" class="form-control text-input" id="documentName" name="documentName" placeholder="Enter Document Name" ng-model="document.Document.name">
		<label for="documentName">Name</label>
	</div>
	
	<tabset>
		<tab heading="Document">

			<div class="btn-group pull-left">
				<button id="documentPublished" type="button" class="btn btn-default {{isPublishedClass}}" name="documentPublished" ng-model="document.Document.published" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">
					<span class="glyphicon glyphicon-cloud-upload control-icon"></span>

					<span class="control-text">
						{{isPublishedText}}
					</span>
				</button>
				<button id="documentIsHomepage" type="button" class="btn btn-default {{isHomepageClass}}" name="documentIsHomepage" ng-model="document.Document.home_page" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">
					<span class="glyphicon glyphicon-home control-icon"></span>

					<span class="control-text">
						{{isHomepageText}}
					</span>
				</button>
			</div>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-primary">
					<span class="glyphicon glyphicon-asterisk control-icon"></span>

					<span class="control-text">
						Preview
					</span>
				</button>

				<button type="button" class="btn btn-primary" ng-show="vm.documentPublished">
					<span class="glyphicon glyphicon-globe control-icon"></span>
					<span class="control-text">
						View Live
					</span>
				</button>
			</div>
			<div class="clearfix"></div>	
			<hr>
			<div class="form-group" title="Alias used for friendly urls">
				<input type="text" class="form-control text-input" id="documentAlias" name="documentAlias" placeholder="Enter Document Alias" ng-model="document.Document.alias">
				<label for="documentAlias">Alias</label>
			</div>
			<label for="documentMeta">Meta Data</label>
			<div class="form-group document-meta" title="Document Meta Data">
				<p class="">id: {{document.Document.id}}</p>
				<p class="">type: {{document.DocumentType.DocumentType.name}}</p>
				<p class="">parent: {{document.parent.Document.name}}</p>
				<p class="">user: {{document.Document.name}}</p>
				<p class="">created: {{document.Document.created}}</p>
				<p class="">last modified: {{document.Document.modified}}</p>
				<p class="" ng-show="vm.documentPublished">url: <a href="/content/{{document.Document.path}}">{{document.Document.path}}</a></p>
			</div>
		</tab>
		<tab heading="Properties" ng-show="document.DocumentType.DocumentTypeProperty">
			<accordion close-others="oneAtATime">
				<accordion-group heading="{{property.DocumentTypeProperty.name}}" ng-repeat="property in document.DocumentType.DocumentTypeProperty">
				<p>{{property.DocumentTypeProperty.id}}</p>
				<p>{{property.DocumentTypeProperty.document_type_id}}</p>
				<p>{{property.DocumentTypeProperty.name}}</p>
			</accordion-group>
		</accordion>
	</tab>
	<tab heading="Parent">
		<div class="btn-group">
			<a class="btn btn-primary" title="Change parent document" ng-click="getDocumentParent()">
				<span class="glyphicon glyphicon-edit control-icon"></span>
				<span class="control-text">
					Change Parent
				</span>
			</a>
		</div>
		<hr>
		<div ng-if="document.parent.Document">
			<div class="form-group" title="The parent document">
				<a name="documentParentName" id="documentParentName" class="form-control text-label" href="#/documents/edit/{{document.parent.Document.id}}">{{document.parent.Document.name}}</a>
				<label for="documentParentName">Parent Name</label>
			</div>
			<label for="documentMeta">Parent Meta Data</label>
			<div class="form-group document-meta" title="Document Meta Data">
				<p class="">id: {{document.parent.Document.id}}</p>
				<p class="">alias: {{document.parent.Document.alias}}</p>
				<p class="">created: {{document.parent.Document.created}}</p>
				<p class="">last modified: {{document.parent.Document.modified}}</p>
				<p class="" ng-show="document.parent.Document.published">parent url: <a href="/content/{{document.parent.Document.path}}">{{document.parent.Document.path}}</a></p>
			</div>
		</div>
	</tab>
	<tab heading="Children">
		<div class="tab-controls">
			<div class="pull-left">
				<div class="btn-group">
					<a class="btn btn-primary" title="Add a child document" href="#/documents/add/{{document.Document.id}}">
						<span class="glyphicon glyphicon-plus control-icon"></span>
						<span class="control-text">
							Add Child Document
						</span>

					</a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<hr>
		<div class="tgrid">
			<div class="grid-item " ng-repeat="document in document.children">
				<a href="#/documents/edit/{{document.Document.id}}">
					<span class="item-icon glyphicon glyphicon-file"></span>
					<div class="caption">
						{{document.Document.name}}
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
				<button type="button" class="btn btn-primary" ng-click="saveDocument()">
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
				<button type="button" class="btn btn-danger" ng-click="deleteDocument()">
					<span class="glyphicon glyphicon-trash control-icon"></span>

					<span class="control-text">
						Delete
					</span>
				</button>
			</div>
		</div>
	</div>
</nav>
</form>
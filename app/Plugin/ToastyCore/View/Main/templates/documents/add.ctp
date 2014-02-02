<form class="container cmsForm" name="cmsForm">
	<div class="flash-messages">
		<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">{{alert.message}}</alert>
	</div>
	<div class="form-group" title="The name for this document">
		<input type="text" class="form-control text-input" id="documentName" name="documentName" placeholder="Enter Document Name" ng-model="document.Document.name">
		<label for="documentName">Document Name</label>
	</div>

	<tabset>
		<tab heading="Document">
			<div class="btn-group">
				<button id="documentPublished"name="documentPublished"  type="button" class="btn btn-default {{isPublishedClass}}" ng-model="document.Document.published" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">
					<span class="glyphicon glyphicon-cloud-upload control-icon"></span>
					<span class="control-text">
						{{isPublishedText}}
					</span>
				</button>
				<button id="documentIsHomepage"name="documentIsHomepage"  type="button" class="btn btn-default {{isHomepageClass}}" ng-model="document.Document.home_page" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">
					<span class="glyphicon glyphicon-home control-icon"></span>

					<span class="control-text">
						{{isHomepageText}}
					</span>
				</button>
			</div>
			<hr>
			<div class="form-group" title="Alias used for friendly urls">
				<input type="text" class="form-control text-input" id="documentAlias"name="documentAlias"  placeholder="Enter Document Alias" ng-model="document.Document.alias">
				<label for="documentAlias">Document Alias</label>
			</div>
		</tab>
		<tab heading="Type & Properties">
			<div class="btn-group">
				<a class="btn btn-primary" title="Change the document type" ng-click="getDocumentType(true)">
					<span class="glyphicon glyphicon-edit control-icon"></span>
					<span class="control-text">
						Change Type
					</span>
				</a>
			</div>
			<hr>
			<div class="form-group" title="The Document Type this Document is based on">
				<span class="form-control text-label text-muted">{{document.DocumentType.DocumentType.name}}</span>
				<label for="documentType">Document Type</label>
			</div>
			<accordion close-others="oneAtATime" ng-show="document.DocumentType.DocumentTypeProperty">
				<accordion-group heading="{{property.name}}" ng-repeat="property in document.DocumentType.DocumentTypeProperty">
					<p>{{property.id}}</p>
					<p>{{property.document_type_id}}</p>
					<p>{{property.name}}</p>
				</accordion-group>
			</accordion>
		</tab>
		<tab heading="Parent">
		<div class="btn-group">
			<a class="btn btn-primary" title="Change parent document"  ng-click="getDocumentParent()">
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
	</tabset>

	<nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse main-nav">
		<div class="page-controls">
			<div class="pull-right">
				<div class="btn-group">
					<button type="button" class="btn btn-primary" ng-click="saveNewDocument()">
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
				</div>
			</div>
		</div>
	</nav>
</form>
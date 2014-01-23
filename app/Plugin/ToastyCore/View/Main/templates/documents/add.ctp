<div class="container cmsForm">
	<div class="flash-messages">
		<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">{{alert.message}}</alert>
	</div>
  <div class="form-group" title="The name for this document">
    <input type="text" class="form-control text-input" id="documentName" placeholder="Enter Document Name" ng-model="document.Document.name">
  		<label for="documentName">Document Name</label>
  </div>
 
  <tabset>
  	<tab heading="Document">
	  <div class="form-group" title="Alias used for friendly urls">
	    	<input type="text" class="form-control text-input" id="documentAlias" placeholder="Enter Document Alias" ng-model="document.Document.alias">
	  		<label for="documentAlias">Document Alias</label>
	  </div>
	  <div class="form-group" title="The Document Type this Document is based on">
	    	<!-- <input type="text" class="form-control text-input" id="documentType" ng-model="document.DocumentType.DocumentType.name" ng-disabled="true"> -->
	    	<a class="form-control text-label" ng-click="goEditDocumentType()">{{document.DocumentType.DocumentType.name}}</a>
	  		<label for="documentType">Document Type</label>
	  </div>
	  <div class="form-group" title="The parent document" ng-show="document.parent.Document">
	    	<!-- <input type="text" class="form-control text-input" id="documentType" ng-model="document.DocumentType.name" ng-disabled="true"> -->
	    	<a class="form-control text-label" ng-click="goEditParentDocument()">{{document.parent.Document.name}}</a>
	  		<label for="documentType">Parent Document</label>
	  </div>


  	</tab>
    <tab heading="Properties" ng-show="document.DocumentType.DocumentTypeProperty">
		<accordion close-others="oneAtATime">
			<accordion-group heading="{{property.name}}" ng-repeat="property in document.DocumentType.DocumentTypeProperty">
				<p>{{property.id}}</p>
				<p>{{property.document_type_id}}</p>
				<p>{{property.name}}</p>
			</accordion-group>
		</accordion>
    </tab>
  </tabset>

	<nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse main-nav">
		<div class="page-controls">
			<div class="pull-left">
				<div class="btn-group">
					<button id="documentPublished" type="button" class="btn btn-default {{isPublishedClass}}" ng-model="document.Document.published" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">
			        	<span class="glyphicon glyphicon-cloud-upload control-icon"></span>

						<span class="control-text">
							{{isPublishedText}}
						</span>
					</button>
					<button id="documentIsHomepage" type="button" class="btn btn-default {{isHomepageClass}}" ng-model="document.Document.home_page" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">
			        	<span class="glyphicon glyphicon-home control-icon"></span>

						<span class="control-text">
							{{isHomepageText}}
						</span>
					</button>
				</div>
			</div>
			<div class="pull-right">
				<div class="btn-group">
			        <button type="button" class="btn btn-primary" ng-click="saveNewDocument()">
			        	<span class="glyphicon glyphicon-save control-icon"></span>
			        	<span class="control-text">
			        		Save
			        	</span>

		        	</button>
			        <button type="button" class="btn btn-primary" ng-click="cancelChanges()">
			        	<span class="glyphicon glyphicon-floppy-remove control-icon"></span>

			        	<span class="control-text">
			        		Cancel
			        	</span>
			        </button>
			    </div>
		    </div>
	    </div>
	</nav>
</div>
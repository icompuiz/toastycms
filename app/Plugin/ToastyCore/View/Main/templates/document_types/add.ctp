<form class="container cmsForm" name="cmsForm">
	<div class="flash-messages">
		<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">{{alert.message}}</alert>
	</div>
	<div class="form-group" title="The name for this document">
		<input type="text" class="form-control text-input" id="documentTypeName" name="documentTypeName" placeholder="Enter Document Type Name" ng-model="document_type.DocumentType.name">
		<label for="documentName">Name</label>
	</div>

	<tabset>
		<tab heading="Type">
		</tab>
		<tab heading="Parent">
		</tab>
		<tab heading="Type">
		</tab>
	</tabset>

	<nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse main-nav">
		<div class="page-controls">
			<div class="pull-right">
				<div class="btn-group">
					<button type="button" class="btn btn-primary" ng-click="saveNewDocumentType()">
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
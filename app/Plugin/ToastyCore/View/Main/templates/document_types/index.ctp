<div class="container">
	<div class="flash-messages">
		<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">{{alert.message}}</alert>
	</div>
	<div class="page-controls">
		<div class="pull-left">
			<div class="btn-group">
				<a href="#/document_types/add" class="btn btn-primary">
					<span class="glyphicon glyphicon-plus control-icon"></span>
					<span class="control-text">
						New Type
					</span>
				</a>
			</div>
		</div>
		<div class="pull-right">
			
		</div>
		<div class="clearfix"></div>	
	</div>
	<div class="tgrid">
		<div class="grid-item" ng-repeat="document_type in document_types">
			<a href="#/document_types/edit/{{document_type.DocumentType.id}}">
				<span class="item-icon glyphicon glyphicon-file"></span>
				<div class="caption">
					{{document_type.DocumentType.name}}
				</div>
			</a>
		</div>
	</div>
</div>
<div class="container">
	<div class="flash-messages">
		<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">{{alert.message}}</alert>
	</div>
	<div class="page-controls">
		<div class="pull-left">
			<div class="btn-group">
		        <button type="button" class="btn btn-primary" ng-click="createDocument()">
			        	<span class="glyphicon glyphicon-plus control-icon"></span>
			        	<span class="control-text">
		        	New Document
			        	</span>
	        	</button>
		</div>
		</div>
		<div class="pull-right">
			
	    </div>
    	<div class="clearfix"></div>	
    </div>
    <div class="tgrid">
		<div class="grid-item" ng-repeat="document in documents">
	        <a href="#/documents/edit/{{document.Document.id}}">
		      <span class="item-icon glyphicon glyphicon-file"></span>
		      <div class="caption">
		        	{{document.Document.name}}
		      </div>
        	</a>
	    </div>
    </div>
</div>
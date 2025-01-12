<?php
	if ( ! defined( 'WPINC' ) ) {
		die;
	}
?>
<!--<div id="postbox-container-1" class="postbox-container">
	<div class="meta-box-sortables">
		<div class="postbox">
			<h3><?php /*esc_html_e( 'Document Attachments', 'cbxwpsimpleaccounting' ); */?></h3>
			<div class="inside">


			</div>
		</div>
	</div>
</div>-->

<div class="cbxwpsimpleaccounting">
	<!-- The file upload form used as target for the file upload widget -->
	<form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
		<!-- Redirect browsers with JavaScript disabled to the origin page -->
		<noscript>
			<input type="hidden" name="redirect" value="<?php echo home_url( '/' ); ?>">
		</noscript>
		<div class="row fileupload-buttonbar">
			<div class="col-lg-12">
								<span class="btn btn-sm btn-success fileinput-button">
									<i class="glyphicon glyphicon-plus"></i>
									<span><?php esc_html_e('Add', 'cbxwpsimpleaccounting'); ?></span>
									<input type="file" name="files[]" multiple>
								</span>
				<!--<button type="submit" class="btn btn-sm btn-primary start">
									<i class="glyphicon glyphicon-upload"></i> <span><?php /*esc_html_e('Upload', 'cbxwpsimpleaccounting'); */?></span>
								</button>
								<button type="reset" class="btn btn-sm btn-warning cancel">
									<i class="glyphicon glyphicon-ban-circle"></i> <span><?php /*esc_html_e('Cancel', 'cbxwpsimpleaccounting'); */?></span>
								</button>-->
				<!--<button type="button" class="btn btn-sm btn-danger delete">
					<i class="glyphicon glyphicon-trash"></i>
				</button>
				<input type="checkbox" class="toggle">-->
				<!-- The global file processing state -->
				<span class="fileupload-process"></span>
			</div>
			<!-- The global progress state -->
			<div class="col-lg-12 fileupload-progress fade">
				<!-- The global progress bar -->
				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
					<div class="progress-bar progress-bar-success" style="width:0%;"></div>
				</div>
				<!-- The extended global progress state -->
				<div class="progress-extended">&nbsp;</div>
			</div>
		</div>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped">
			<tbody class="files"></tbody>
		</table>
	</form>
	<!-- The template to display files available for upload -->
	<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
       <!-- <td>
            <span class="preview"></span>
        </td>-->
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-sm btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span><?php esc_html_e('Start', 'cbxwpsimpleaccounting'); ?></span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-sm btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span><?php esc_html_e('Cancel', 'cbxwpsimpleaccounting'); ?></span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}

					</script>
	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
       <!-- <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>-->
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%} title="{%=file.name%}">{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger"><?php esc_html_e('Error', 'cbxwpsimpleaccounting'); ?></span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-sm btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                </button>
                <!--<input type="checkbox" name="delete" value="1" class="toggle">-->
            {% } else { %}
                <button class="btn btn-sm btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span><?php esc_html_e('Cancel', 'cbxwpsimpleaccounting'); ?></span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}

					</script>
</div>
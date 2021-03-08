import {registerBlockType} from '@wordpress/blocks';
import { TextControl, PanelBody, PanelRow, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { InspectorControls, MediaUpload } from '@wordpress/block-editor';

/* REgistro de un bloque que se visualizar en el back y front de WP */
registerBlockType(
    'ajar/basic',
    {
        title: "Basic Block",
        description: "It this is my first block",
        icon: "smiley",
        category: "layout",
        attributes: {
            content: {
                type: "string",
                default: 'Hello World'
            },
            mediaURL: {
                type: 'string'
            },
            mediaAlt: {
                type: 'string'
            }
        },
        edit: (props) => {
            const { attributes: {content}, setAttributes, className, isSelected} =props;
            // funcion para guardar el atrributo content
            const handlerOnChangeInput = (newContent) => {
                setAttributes( {content: newContent})
            }
            const handlerOnSelectMediaUpload = (image) => {
                setAttributes({
                    mediaURL: image.sizes.full.url,
                    mediaAlt: image.alt 
                })
            }
            return <>
                <InspectorControls>
                    <PanelBody title="Update text of block basic ajar" initialOpen={true}>
                        <PanelRow>
                            <TextControl
                                label="Complete el Campo"
                                value={content}
                                onChange={handlerOnChangeInput}
                            />
                        </PanelRow>
                    </PanelBody>
                    <PanelBody title="Selecciona una Imagen" initialOpen={true}>
                        <PanelRow>
                            <MediaUpload
                                onSelect= { handlerOnSelectMediaUpload }
                                type="image"
                                render={({open}) => {
                                    return <Button className="components-icon-button image-block-btn is-button is-default is-large" onClick={open}> Elije una imagen </Button>;
                                }}
                            />
                        </PanelRow>
                    </PanelBody>
                </InspectorControls>

                <ServerSideRender block="ajar/basic" attributes={props.attributes} />
            </>
        },
        //para comparar save con edit
        // save: (props) => <h2>{props.attributes.content}</h2>
        save: () => null
    }
)

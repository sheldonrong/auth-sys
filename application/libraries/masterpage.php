<?php if ( ! defined ( 'BASEPATH' ) ) exit ( 'No direct script access allowed.' );
/**
 * @author Kim Johansson <hagbarddenstore@gmail.com>
 * @copyright Copyright (c) 2008, Kim Johansson
 *
 * @modified Sheldon Rong
 * @add: utilise smarty template system for masterpage,
 *       places being modified will be marked with @MODIFIED
 * @version 0.0.2
 */
class MasterPage {
    private $masterPage = '';
    private $contentPages = array ( );
    private $ci = null;

    /**
     * @access public
     * @param string $masterPage Optional file to use as MasterPage.
     */
    public function __construct ( $masterPage = '' ) {
        $this->CI = get_instance ( );
        if ( ! empty ( $masterPage ) )
            $this->setMasterPage ( $masterPage );
    }

    /**
     * @access public
     * @param string $masterPage File to use as MasterPage.
     */
    public function setMasterPage ( $masterPage ) {
        // Check if the supplied masterpage exists.
        if ( ! file_exists ( APPPATH . 'views/' . $masterPage . EXT ) )
            throw new Exception ( APPPATH . 'views/' . $masterPage . EXT );
        $this->masterPage = $masterPage;
    }

    /**
     * @access public
     * @return string The current MasterPage.
     */
    public function getMasterPage ( ) {
        return $this->masterPage;
    }

    /**
     * @access public
     * @param string $file The view file to add.
     * @param string $tag The tag in the MasterPage it should match.
     * @param mixed $content The content to be used in the view file.
     */
    public function addContentPage ( $file, $tag, $content = array ()) {
        $this->contentPages[$tag] = $this->CI->parser->parse($file, $content, true); //@MODIFIED
    }

    /**
     * @access public
     * @param array $content Optional content to be added to the MasterPage.
     */
    public function show ( $content = array ( ) ) {
        // Get the content of the MasterPage and replace all matching tags with their
        // respective view file content.
        $masterPage = $this->CI->parser->parse($this->masterPage, $content, true); //@MODIFIED
        foreach ( $this->contentPages as $tag => $content ) {
            $masterPage = str_replace ( '<mp:' . ucfirst ( strtolower ( $tag ) ) . ' />',
            $content, $masterPage );
        }
        // Finally, print the data.
        echo $masterPage;
    }
}
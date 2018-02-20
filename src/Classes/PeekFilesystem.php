<?php

namespace Misma\MailPeek\Classes;


use FilesystemIterator;
use Illuminate\Filesystem\Filesystem;

class PeekFilesystem extends Filesystem
{
	public function cleanDirectoryExcept($directory, $exclude=[]){
		if (! $this->isDirectory($directory)) {
            return false;
        }

        $items = new FilesystemIterator($directory);

        foreach ($items as $item) {
        	// Check if file/dir is in the excluded list
        	if(in_array($item->getFilename(),$exclude)){
        		continue;
        	}
            
            if ($item->isDir() && ! $item->isLink()) {
                $this->deleteDirectory($item->getPathname());
            } else {
                $this->delete($item->getPathname());
            }
        }

        return true;	
	}
}
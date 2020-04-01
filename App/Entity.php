<?php
	namespace App;
    
    /**
     * Abstract class of all classes that represents a table in the database.
     * 
     * @method hydrate() Set all fields of the object based on a SQL response.
     * @method getClass() Get the class name of the current object.
     */
    abstract class Entity{

        // ---- METHODS ----
        
        /**
         * Set all required fields of the object based on a SQL response.
         *
         * @param array $data Raw SQL response row.
         */
        protected function hydrate($data)
        {
            // For each '$data' column, hydrate the current object
            foreach($data as $field => $value)
            {
                $fieldArray = explode("_", $field);

                if (isset($fieldArray[1])){
                    // If the second word is id -> foreign key
                    if ($fieldArray[1] == "id")
                    {
                        $manName = ucfirst($fieldArray[0]) . "Manager";
                        $classWithNamespace = "Model\Managers\\" . $manName;
                        $man = new $classWithNamespace();
                        $value = $man->findOneById($value);
                    }
                    // Otherwise if it is one field composed of multiple words
                    else if ($fieldArray[0] != "id")
                        for ($i = 1; $i < count($fieldArray); $i++)
                            $fieldArray[0] .= ucfirst($fieldArray[$i]);
                }

                // Check if the current field can be stored in the object, using the 'set<Field>'
                $method = "set" . ucfirst($fieldArray[0]);
                if(method_exists($this, $method))
                    $this->$method($value);
                else{
                    echo $method . " existe pas ! (" . get_class($this) . ")<br />";
                }
            }
        }
        
        /**
         * Get the class name of the current object.
         *
         * @param bool=false $withNamespace Class name with full namespace.
         * @return string The class name of the object.
         */
        public function getClass($withNamespace = false)
        {
            if ($withNamespace)
                return __CLASS__;
            return array_pop(explode('\\', __CLASS__));
        }
    }
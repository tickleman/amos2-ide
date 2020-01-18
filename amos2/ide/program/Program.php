<?php
namespace Amos2\Ide;

use Amos2\Ide\Compiler\Versions;
use Amos2\Ide\Program\Resource;
use ITRocks\Framework\Controller\Feature;
use ITRocks\Framework\Dao;
use ITRocks\Framework\Traits\Duplicate_Discriminate_By_Counter;
use ITRocks\Framework\Traits\Has_Creation_Date_Time;
use ITRocks\Framework\Traits\Has_Name;
use ITRocks\Framework\Traits\Has_Name_Duplicate;
use ITRocks\Framework\Traits\Has_Update_Date_Time;
use ITRocks\Framework\User;

/**
 * @before_write setNewProgramAuthor
 * @business
 * @data_access_control isChangeAllowed
 * @display_order name, author, code, version, resources
 * @feature
 * @list name, author, last_update
 * @override creation    @user invisible_edit, invisible_output
 * @override last_update @user invisible_edit, invisible_output
 */
class Program
{
	use Duplicate_Discriminate_By_Counter;
	use Has_Creation_Date_Time;
	use Has_Name_Duplicate;
	use Has_Name;
	use Has_Update_Date_Time;

	//--------------------------------------------------------------------------------------- $author
	/**
	 * @default User::current
	 * @link Object
	 * @mandatory
	 * @user invisible_edit
	 * @var User
	 */
	public $author;

	//----------------------------------------------------------------------------------------- $code
	/**
	 * @max_length 10000000
	 * @multiline
	 * @var string
	 */
	public $code;

	//------------------------------------------------------------------------------------ $resources
	/**
	 * @link Collection
	 * @var Resource[]
	 */
	public $resources;

	//------------------------------------------------------------------------------------ $resources
	/**
	 * @default Versions::default
	 * @mandatory
	 * @see Versions::default
	 * @var string
	 */
	public $version;

	//--------------------------------------------------------------------------------------- dirName
	/**
	 * A directory name that identifies the program (author and project name)
	 *
	 * @example tickleman/helloworld
	 * @param $separator string
	 * @return string
	 */
	public function dirName($separator = SL)
	{
		return str_replace(
			DOT, '-', strUriElement($this->author->login) . $separator . strUriElement($this->name)
		);
	}

	//------------------------------------------------------------------------------- isChangeAllowed
	/**
	 * @param $feature string
	 * @return boolean
	 */
	public function isChangeAllowed($feature)
	{
		if (
			!in_array($feature, [Feature::F_DELETE, Feature::F_SAVE])
			|| Dao::is(User::current(), $this->author)
		) {
			return true;
		}
		return false;
	}

	//--------------------------------------------------------------------------- setNewProgramAuthor
	public function setNewProgramAuthor()
	{
		if (!Dao::getObjectIdentifier($this)) {
			$this->author = User::current();
		}
	}

}

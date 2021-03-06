<?php
namespace MapasCulturais\Repositories;
use MapasCulturais\Traits;
use MapasCulturais\Entities\ProjectOpportunity;
use MapasCulturais\Entities\Project;

class Opportunity extends \MapasCulturais\Repository{
    use Traits\RepositoryKeyword,
        Traits\RepositoryAgentRelation;


    function findByProjectAndOpportunityMeta(Project $project, $key, $value) {
        $projectsIds = $project->getChildrenIds();
        $projectsIds[] = $project->id;

        try {
            $query = $this->_em->createQuery("
            SELECT 
                po
            FROM
                MapasCulturais\Entities\OpportunityMeta om
                JOIN MapasCulturais\Entities\ProjectOpportunity po WITH om.owner=po
                JOIN po.ownerEntity oe
                WHERE om.key=:key AND om.value=:value AND oe.id in (:projectsIds)
            ");
        
            $params = [
                'projectsIds' => $projectsIds,
                'key'=>$key,
                'value'=>$value
            ];

            $query->setParameters($params);

            return $query->getResult();
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    
}


<?php

namespace App\Support;

class SchoolPermissions
{
    public const CATALOG = [
        'students.view' => 'Consulter les élèves et inscriptions',
        'students.manage' => 'Créer et modifier les élèves et inscriptions',
        'academics.view' => 'Consulter les classes, enseignants et emplois du temps',
        'academics.manage' => 'Gérer les classes, enseignants, matières et emplois du temps',
        'grades.view' => 'Consulter les notes et bulletins',
        'grades.manage' => 'Saisir et modifier les notes',
        'finance.view' => 'Consulter les paiements et scolarités',
        'finance.manage' => 'Enregistrer les paiements',
        'services.view' => 'Consulter les abonnements aux services',
        'services.manage' => 'Gérer les abonnements aux services',
        'settings.manage' => 'Modifier l’établissement et les années scolaires',
    ];

    public const ACTIONS = [
        'student' => 'students.manage', 'enrollment' => 'students.manage',
        'enrollment-approve' => 'students.manage', 'enrollment-reject' => 'students.manage',
        'teacher' => 'academics.manage', 'class' => 'academics.manage', 'subject' => 'academics.manage',
        'lesson' => 'academics.manage', 'lesson-delete' => 'academics.manage',
        'grades' => 'grades.manage', 'payment' => 'finance.manage',
        'subscription' => 'services.manage', 'subscription-toggle' => 'services.manage',
        'year' => 'settings.manage', 'year-activate' => 'settings.manage', 'settings' => 'settings.manage',
        'account' => 'users.manage', 'account-status' => 'users.manage', 'account-password' => 'users.manage',
        'role' => 'roles.manage', 'role-delete' => 'roles.manage',
    ];

    public static function normalize(array $permissions): array
    {
        $result = array_values(array_intersect(array_keys(self::CATALOG), $permissions));
        foreach (['students', 'academics', 'grades', 'finance', 'services'] as $module) {
            if (in_array($module.'.manage', $result, true)) {
                $result[] = $module.'.view';
            }
        }
        // Linked modules need the student records and class labels to display their records.
        if (array_intersect(['grades.view', 'finance.view', 'services.view'], $result)) {
            $result[] = 'students.view';
        }
        if (in_array('grades.view', $result, true)) {
            $result[] = 'academics.view';
        }

        return array_values(array_unique($result));
    }
}

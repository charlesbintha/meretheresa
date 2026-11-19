<?php

namespace App\Support;

class SchoolPermissions
{
    public const CATALOG = [
        'accounting.view'=>'Consulter la comptabilité et les états', 'accounting.manage'=>'Préparer les écritures comptables', 'accounting.post'=>'Valider les écritures comptables', 'accounting.configure'=>'Configurer et clôturer la comptabilité',
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
        'expense-supplier'=>'accounting.manage','expense-save'=>'accounting.manage','expense-payment'=>'accounting.manage','expense-payment-cancel'=>'accounting.manage','expense-post'=>'accounting.post',
        'accounting-entry'=>'accounting.manage','accounting-prepare'=>'accounting.manage','accounting-reverse'=>'accounting.manage','accounting-post'=>'accounting.post','accounting-year'=>'accounting.configure','accounting-close'=>'accounting.configure','accounting-treasury'=>'accounting.configure','accounting-account'=>'accounting.configure',
        'student-profile'=>'students.manage',
        'staff-profile'=>'services.manage', 'staff-membership'=>'services.manage', 'staff-receipt'=>'finance.manage',
        'billing-receipt'=>'finance.manage', 'billing-waiver'=>'finance.manage', 'billing-membership'=>'services.manage', 'billing-enrollment'=>'students.manage',
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
        if (array_intersect(['accounting.manage','accounting.post','accounting.configure'], $result)) $result[]='accounting.view';
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

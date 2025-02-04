<?php
use Statistic\StatisticsManager;
use Connection\database\Database;
require_once('../Model/Database.php');
require_once('../Model/Statistics.php');
session_start();
$database=new Database();
$db=$database->getConnection();
$stats = new StatisticsManager($db);
?>

<style>
        .stats-container {
            padding: 1.5rem 1rem;
        }

        .stats-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
        }

        .stats-grid {
            margin-top: 1.5rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        @media (min-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .stat-card {
            background-color: white;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }

        .stat-content {
            padding: 1.25rem;
        }

        .stat-icon-wrapper {
            display: flex;
            align-items: center;
        }

        .stat-icon {
            flex-shrink: 0;
        }

        .stat-icon-circle {
            height: 3rem;
            width: 3rem;
            background-color: black;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon-text {
            color: white;
            font-size: 1.5rem;
        }

        .stat-info {
            margin-left: 1.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #6B7280;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
        }
</style>

<div class="stats-container">
    <h1 class="stats-title">Tableau de bord</h1>
    <div class="stats-grid">
        <!-- Total Students -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-icon-wrapper">
                    <div class="stat-icon">
                        <div class="stat-icon-circle">
                            <span class="stat-icon-text">👥</span>
                        </div>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">
                            Total Étudiants
                        </div>
                        <div class="stat-value">
                            <?php echo number_format($stats->getTotalStudents($_SESSION['user_id'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Courses -->
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-icon-wrapper">
                    <div class="stat-icon">
                        <div class="stat-icon-circle">
                            <span class="stat-icon-text">📚</span>
                        </div>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">
                            Cours Actifs
                        </div>
                        <div class="stat-value">
                            <?php echo number_format($stats->getActiveCourses($_SESSION['user_id'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
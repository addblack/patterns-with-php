<?php

interface ReportFormat {
    public function generate(string $data): string;
}

abstract class Report {
    protected ReportFormat $format;

    public function __construct(ReportFormat $format) {
        $this->format = $format;
    }

    abstract public function generateReport(): string;
}

// Daily report 
class DailyReport extends Report {
    public function generateReport(): string {
        $data = "Daily sales report data"; // Simulating data for daily report
        return $this->format->generate($data);
    }
}

// Weekly report 
class WeeklyReport extends Report {
    public function generateReport(): string {
        $data = "Weekly sales report data"; // Simulating data for weekly report
        return $this->format->generate($data);
    }
}

// Text file format implementation
class TextFileFormat implements ReportFormat {
    public function generate(string $data): string {
        // Logic to save data to a text file (simulated here)
        $filename = 'sales_report.txt';
        file_put_contents($filename, $data);
        return "Report saved to file: " . $filename;
    }
}

// String format implementation
class StringFormat implements ReportFormat {
    public function generate(string $data): string {
        // Returning the report as a string
        return "Sales Report (String Format): " . $data;
    }
}

// Code to test
function clientCode() {
    $dailyReport = new DailyReport(new TextFileFormat());
    echo $dailyReport->generateReport();

    $weeklyReport = new WeeklyReport(new StringFormat());
    echo "\n" . $weeklyReport->generateReport();
}

clientCode();
